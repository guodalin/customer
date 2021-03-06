<?php

namespace App\Http\Controllers\Mnp\Auth;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Wechat\MiniProgramRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * 微信小程序登录.
     *
     * @param  \Illuminate\Http\Request                                $request
     * @param  \App\Repositories\Frontend\Wechat\MiniProgramRepository $miniProgramRepository
     * @param  null|string                                             $name
     * @throws GeneralException
     * @throws AuthenticationException
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request, MiniProgramRepository $miniProgramRepository, $name = null)
    {
        $this->validate($request, [
            'session_key' => 'required_without:code',
            'code' => 'required_without:session_key',
            'base' => 'required|array',
            'phone' => 'array',
        ]);

        $miniProgramRepository->init($name);

        $sessKey = $request->input('session_key');

        if ($sessKey) {
            $miniProgramRepository->setSessionKey($sessKey);
        } else {
            $miniProgramRepository->auth($request->input('code'));
        }

        $user = $miniProgramRepository->login($request->input('base'), $request->input('phone'));

        if ($user) {
            // cache user's key
            $miniProgramRepository->store($user);

            // Check to see if the users account is confirmed and active
            if (!$user->isConfirmed()) {
                // If the user is pending (account approval is on)
                if ($user->isPending()) {
                    throw new GeneralException(__('exceptions.frontend.auth.confirmation.pending'));
                }

                // Otherwise see if they want to resent the confirmation e-mail
                throw new GeneralException(__('exceptions.frontend.auth.confirmation.resend', [
                    'url' => route('frontend.auth.account.confirm.resend', $user->hashid()),
                ]));
            } elseif (!$user->isActive()) {
                throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
            }

            return ['message' => __('alerts.frontend.auth.succeed'), 'access_token' => $miniProgramRepository->sessKey];
        }

        throw new AuthenticationException();
    }
}
