<?php

namespace App\Models\Auth;

use Comcsoft\Comment\Traits\CanComment;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\Traits\SendUserPasswordReset;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User.
 */
abstract class BaseUser extends Authenticatable implements HasMedia
{
    use HasRoles,
        Impersonate,
        Notifiable,
        SendUserPasswordReset,
        SoftDeletes,
        HasApiTokens,
        HasMediaTrait,
        CanComment,
        LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'username',
        'email',
        'mobile',
        'avatar_type',
        'avatar_location',
        'password',
        'password_changed_at',
        'active',
        'confirmation_code',
        'confirmed',
        'timezone',
        'last_login_at',
        'last_login_ip',
        'to_be_logged_out',
    ];

    /*-------------------------------------------
     * Attributes to log the event.
     */
    protected static $logName = 'system';

    protected static $logAttributes = [
        'username', 'mobile', 'email', 'password_changed_at',
        'timezone', 'last_login_at', 'last_login_ip',
    ];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     * @var array
     */
    protected $appends = [
        'full_name',
    ];

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    // ------------------------------------------

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active'           => 'boolean',
        'confirmed'        => 'boolean',
        'to_be_logged_out' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'last_login_at',
        'password_changed_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'media',
    ];

    /**
     * 通过用户名查找用户.
     *
     * @param  string $username
     * @return self
     */
    public function findForPassport($username)
    {
        return auth()->guard()->getProvider()->retrieveByCredentials([config('access.users.username') => $username]);
    }

    /**
     * 验证用户密码
     *
     * @param  string $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        return auth()->guard()->getProvider()->validateCredentials($this, ['password' => $password]);
    }

    /**
     * 为用户头像注册mediacollections.
     */
    public function registerMediaCollections()
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CROP, config('gravatar.default.size'), config('gravatar.default.size'))
                    ->format(Manipulations::FORMAT_PNG)
                    ->background('transparent')
                    ->optimize();
            });
    }

    /**
     * Return true or false if the user can impersonate an other user.
     *
     * @param void
     * @return  bool
     */
    public function canImpersonate()
    {
        return $this->isAdmin();
    }

    /**
     * Return true or false if the user can be impersonate.
     *
     * @param void
     * @return  bool
     */
    public function canBeImpersonated()
    {
        return $this->id !== 1;
    }
}
