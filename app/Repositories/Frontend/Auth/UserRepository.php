<?php

namespace App\Repositories\Frontend\Auth;

use App\Events\Frontend\Auth\UserConfirmed;
use App\Events\Frontend\Auth\UserProviderRegistered;
use App\Exceptions\GeneralException;
// use Illuminate\Support\Facades\Storage;
use App\Models\Auth\SocialAccount;
use App\Models\Auth\User;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Repositories\Backend\Access\User\SocialRepository;
use App\Repositories\BaseRepository;
use Comcsoft\Ucenter\Repositories\UcenterRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param $token
     *
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function findByPasswordResetToken($token)
    {
        foreach (DB::table(config('auth.passwords.users.table'))->get() as $row) {
            if (password_verify($token, $row->token)) {
                return $this->getByColumn($row->email, 'email');
            }
        }

        return false;
    }

    /**
     * @param $uuid
     *
     * @throws GeneralException
     * @return mixed
     */
    public function findByUuid($uuid)
    {
        $user = $this->model
            ->uuid($uuid)
            ->first();

        if ($user instanceof $this->model) {
            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.not_found'));
    }

    /**
     * @param $code
     *
     * @throws GeneralException
     * @return mixed
     */
    public function findByConfirmationCode($code)
    {
        $user = $this->model
            ->where('confirmation_code', $code)
            ->first();

        if ($user instanceof $this->model) {
            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.not_found'));
    }

    /**
     * @param array $data
     *
     * @throws \Exception
     * @throws \Throwable
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $insert = [
                'username'          => $data['username'],
                'first_name'        => $data['first_name'] ?? $data['username'],
                'last_name'         => $data['last_name'] ?? null,
                'email'             => $data['email'],
                'mobile'            => $data['mobile'] ?? null,
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'active'            => true,
                'password'          => $data['password'],
                // If users require approval or needs to confirm email
                'confirmed' => !(config('access.users.requires_approval') || config('access.users.confirm_email')),
            ];

            if (should_sync_with_ucenter()) {
                $insert['id'] = resolve(UcenterRepository::class)->create($insert['username'], $insert['password'], $insert['email']);
            }

            $user = parent::create($insert);

            if ($user) {
                // Add the default site role to the new user
                $user->assignRole(config('access.users.default_role'));
            }

            /*
             * If users have to confirm their email and this is not a social account,
             * and the account does not require admin approval
             * send the confirmation email
             *
             * If this is a social account they are confirmed through the social provider by default
             */
            if (config('access.users.confirm_email')) {
                // Pretty much only if account approval is off, confirm email is on, and this isn't a social account.
                $user->notify(new UserNeedsConfirmation($user->confirmation_code));
            }

            // Return the user object
            return $user;
        });
    }

    /**
     * 使用手机号注册.
     *
     * @param  string                $phone
     * @return \App\Models\Auth\User
     */
    public function createUsingMobile(string $phone)
    {
        // 指定唯一的用户名 15位 符合 uc 长度
        $faker = $this->genUserNameAndEmail('phone');
        $password = Str::random(6);

        return $this->create([
            'first_name' => null,
            'last_name'  => null,
            'username'   => $faker['name'],
            'email'      => $faker['email'],
            'mobile'     => $phone,
            'password'   => $password,
        ]);
    }

    /**
     * @param                   $id
     * @param array             $input
     * @param bool|UploadedFile $image
     *
     * @throws GeneralException
     * @return array|bool
     */
    public function update($id, array $input, $image = false)
    {
        $user = $this->getById($id);

        if (isset($input['username']) && !empty($input['username'])) {
            $user->username = $input['username'];

            // 如果修改用户名, 那么需要同步到ucenter
            if (should_sync_with_ucenter()) {
                try {
                    resolve(UcenterRepository::class)->updateUserName($user->id, $input['username']);
                } catch (\Throwable $th) {
                    throw ValidationException::withMessages(['username' => $th->getMessage()]);
                }
            }
        }

        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->avatar_type = $input['avatar_type'];

        // Upload profile image if necessary
        if ($image) {
            $user->addMedia($image)
                ->sanitizingFileName(function ($fileName) {
                    return sanitize_filename($fileName);
                })
                ->toMediaCollection('avatar');
        // $user->avatar_location = $image->store('/avatars', 'public');
        } else {
            // No image being passed
            if ($input['avatar_type'] === 'storage') {
                // If there is no existing image
                // if (auth()->user()->avatar_location === '') {
                // throw new GeneralException('You must supply a profile image.');
                // }
                if (!$user->getFirstMedia('avatar')) {
                    throw ValidationException::withMessages(['avatar_location' => __('validation.attributes.frontend.upload_avatar')]); //GeneralException('You must supply a profile image.');
                }
            }
            // If there is a current image, and they are not using it anymore, get rid of it
                // if (auth()->user()->avatar_location !== '') {
                //     Storage::disk('public')->delete(auth()->user()->avatar_location);
                // }

                // $user->avatar_location = null;
        }

        if ($user->canChangeEmail()) {
            //Address is not current address so they need to reconfirm
            if ($user->email !== $input['email']) {
                //Emails have to be unique
                if ($this->getByColumn($input['email'], 'email')) {
                    throw new GeneralException(__('exceptions.frontend.auth.email_taken'));
                }

                if (should_sync_with_ucenter()) {
                    try {
                        resolve(UcenterRepository::class)->update($user->username, '', '', $input['email']);
                    } catch (\Throwable $th) {
                        throw ValidationException::withMessages(['email' => $th->getMessage()]);
                    }
                }

                // Force the user to re-verify his email address if config is set
                if (config('access.users.confirm_email')) {
                    $user->confirmation_code = md5(uniqid(mt_rand(), true));
                    $user->confirmed = false;
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                }
                $user->email = $input['email'];
                $updated = $user->save();

                // Send the new confirmation e-mail

                return [
                    'success'       => $updated,
                    'email_changed' => true,
                ];
            }
        }

        // #TODO: update mobile phone

        return $user->save();
    }

    /**
     * @param      $input
     * @param bool $expired
     *
     * @throws GeneralException
     * @return bool
     */
    public function updatePassword($input, $expired = false)
    {
        $user = $this->getById(auth()->id());

        if (should_sync_with_ucenter()) {
            try {
                return resolve(UcenterRepository::class)->update($user->username, $input['old_password'], $input['password']);
            } catch (\Throwable $th) {
                throw new GeneralException($th->getMessage());
            }
        } elseif (Hash::check($input['old_password'], $user->password)) {
            if ($expired) {
                $user->password_changed_at = now()->toDateTimeString();
            }

            return $user->update(['password' => $input['password']]);
        }

        throw new GeneralException(__('exceptions.frontend.auth.password.change_mismatch'));
    }

    /**
     * @param $code
     *
     * @throws GeneralException
     * @return bool
     */
    public function confirm($code)
    {
        $user = $this->findByConfirmationCode($code);

        if ($user->confirmed === true) {
            throw new GeneralException(__('exceptions.frontend.auth.confirmation.already_confirmed'));
        }

        if ($user->confirmation_code === $code) {
            $user->confirmed = true;

            event(new UserConfirmed($user));

            return $user->save();
        }

        throw new GeneralException(__('exceptions.frontend.auth.confirmation.mismatch'));
    }

    /**
     * @param mixed       $data
     * @param string      $provider
     * @param string|null $phone    手机号码
     *
     * @throws GeneralException
     * @return mixed
     */
    public function findOrCreateProvider($data, $provider, $phone = null)
    {
        // correct name first
        $provider = $this->correctProviderName($provider);

        // User email may not provided.
        $user_email = $data->email ?: "{$data->id}@{$provider}.com";

        // Check to see if there is a user with this email first.
        $user = $this->getByColumn($user_email, 'email');

        // check phone number
        // sometimes we want to find a user by their phone
        if ($phone) {
            $user = $this->getByColumn($phone, 'mobile');
        }

        /*
         * If the user does not exist create them
         * The true flag indicate that it is a social account
         * Which triggers the script to use some default values in the create method
         */
        if (!$user) {
            // Registration is not enabled
            if (!config('access.registration')) {
                throw new GeneralException(__('exceptions.frontend.auth.registration_disabled'));
            }

            $socialRepository = resolve(SocialRepository::class);

            $socialAccount = $socialRepository->findByProvider($provider, $data->id);

            if ($socialAccount) {
                $user = $socialAccount->user()->withTrashed()->first();
            }

            // 如果还是没有找到用户
            if (!$user) {
                // Get users first name and last name from their full name
                $nameParts = $this->getNameParts($data->getName(), $data->getNickname());

                $faker = $this->genUserNameAndEmail($provider);

                $userData = [
                    'first_name' => $nameParts['first_name'],
                    'last_name'  => $nameParts['last_name'],
                    'username'   => $faker['name'],
                    'email'      => $faker['email'],
                    'mobile'     => $phone,
                    'password'   => Str::random(6),
                ];

                $user = $this->create($userData);

                // next we will change avatar type for user
                // $user->avatar_type = $provider;
                // $user->save();

                event(new UserProviderRegistered($user));
            }
        }

        // See if the user has logged in with this social account before
        if (!$user->hasProvider($provider)) {
            // Gather the provider data for saving and associate it with the user
            $user->providers()->save(new SocialAccount([
                'provider'    => $provider,
                'provider_id' => $data->id,
                'token'       => $data->token,
                'avatar'      => $data->avatar,
            ]));
        } else {
            // Update the users information, token and avatar can be updated.
            $user->providers()
                ->where('provider', $provider)
                ->update([
                    'token'  => $data->token,
                    'avatar' => $data->avatar,
                ]);

            $user->avatar_type = $provider;
            $user->save();
        }

        // Return the user object
        return $user;
    }

    /**
     * @param $fullName
     * @param  mixed $nickName
     * @return array
     */
    protected function getNameParts($fullName, $nickName = null)
    {
        if (!$fullName) {
            $fullName = $nickName;
        }

        $parts = array_values(array_filter(explode(' ', $fullName)));
        $size = count($parts);
        $result = [];

        if (empty($parts)) {
            $result['first_name'] = null;
            $result['last_name'] = null;
        }

        if (!empty($parts) && $size === 1) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = null;
        }

        if (!empty($parts) && $size >= 2) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = $parts[1];
        }

        return $result;
    }

    /**
     * 纠正提供者名称.
     *
     * weixinweb 和 weixin 使用一个即可
     *
     * @param  string $provider
     * @return string
     */
    public function correctProviderName($provider)
    {
        if ($provider == 'weixinweb') {
            return 'weixin';
        }

        return $provider;
    }

    /**
     * 根据provider生成ucenter用户名和邮箱.
     *
     * @param  string $provider
     * @return array
     */
    protected function genUserNameAndEmail($provider)
    {
        // correct provider name first
        $provider = $this->correctProviderName($provider);

        $prefix = $provider.'_';

        // 保证name为15个字符, 因为ucenter的限制
        $name = $prefix.Str::random(15 - strlen($prefix));

        // ucenter email 为 32 个字符, 目前不用判断长度
        $email = Str::lower($name).'@'.$provider.'.com';

        return compact('name', 'email');
    }
}
