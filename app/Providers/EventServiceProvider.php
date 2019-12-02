<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Overtrue\LaravelWeChat\Events\WeChatUserAuthorized;
use SocialiteProviders\Manager\SocialiteWasCalled;

/**
 * Class EventServiceProvider.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        WeChatUserAuthorized::class => [
            'App\Listeners\Frontend\Auth\WechatAuthorizeListener',
        ],

        SocialiteWasCalled::class => [
            'SocialiteProviders\WeixinWeb\WeixinWebExtendSocialite',  // for weixin web
            'SocialiteProviders\Weibo\WeiboExtendSocialite',          // for weibo
            'SocialiteProviders\QQ\QqExtendSocialite',                 // for qq
            'SocialiteProviders\Weixin\WeixinExtendSocialite',   // for weixin offical
        ],
    ];

    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
        // Frontend Subscribers

        // Auth Subscribers
        \App\Listeners\Frontend\Auth\UserEventListener::class,

        // Backend Subscribers

        // Auth Subscribers
        \App\Listeners\Backend\Auth\User\UserEventListener::class,
        \App\Listeners\Backend\Auth\Role\RoleEventListener::class,
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();

        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
