<?php

namespace App\Providers;

use App\Guards\WechatMiniProgramTokenGuard;
use App\UserProviders\AutoUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

/**
 * Class AuthServiceProvider.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        $this->registerAutoUserProvider();

        $this->checkSuperAdmin();

        $this->bindWechatMiniProgramGuard();
    }

    /**
     * register user provider for auto detecting user credentials.
     */
    protected function registerAutoUserProvider()
    {
        Auth::provider('auto', function ($app, array $config) {
            return new AutoUserProvider($app['hash'], $config['model']);
        });
    }

    /**
     * pass through if is super admin.
     */
    protected function checkSuperAdmin()
    {
        // Implicitly grant "Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user) {
            return $user->hasRole(config('access.users.admin_role')) ? true : null;
        });
    }

    /**
     * bind wechat miniprogram guard.
     */
    protected function bindWechatMiniProgramGuard()
    {
        Auth::extend('3rdsess', function ($app, $name, array $config) {
            return new WechatMiniProgramTokenGuard(Auth::createUserProvider($config['provider']), $app['request'], 'sessionid');
        });
    }
}
