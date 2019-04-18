<?php

namespace App\Listeners\Frontend\Auth;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Overtrue\LaravelWeChat\Events\WeChatUserAuthorized;
use App\Repositories\Frontend\Auth\UserRepository;

class WechatAuthorizeListener
{
    /**
     * 用户仓库
     *
     * @var \App\Repositories\Frontend\Auth\UserRepository
     */
    public $userRepository;

    /**
     * weixin provider name
     */
    public const PROVIDER_NAME = 'weixin';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the event.
     *
     * @param  WeChatUserAuthorized  $event
     * @return void
     */
    public function handle(WeChatUserAuthorized $event)
    {
        $wechatUser = $event->getUser();

        if ($event->isNewSession()) {
            // set provider name
            // why this step?
            $wechatUser->setProviderName(static::PROVIDER_NAME);

            // 尝试获取微信的unionid,
            $original = $wechatUser->getOriginal();

            if ($original && isset($original['unionid']) && !empty($original['unionid'])) {
                $wechatUser->setAttribute('id', $original['unionid']);
            }

            $user = $this->userRepository->findOrCreateProvider($wechatUser, static::PROVIDER_NAME);

            auth()->login($user, true);
        }
    }
}
