<?php

namespace App\Helpers\Auth;

use Jenssegers\Agent\Facades\Agent;

/**
 * Class Socialite.
 */
class SocialiteHelper
{
    /**
     * Generates social login links based on what is enabled.
     *
     * @return string
     */
    public function getSocialLinks()
    {
        $socialite_enable = [];
        $socialite_links = '';

        // if (config('services.bitbucket.active')) {
        //     $socialite_enable[] = '<a href="' . route('frontend.auth.social.login', 'bitbucket') . '" class="btn btn-brand btn-bitbucket m-1"><i class="fab fa-bitbucket"></i> <span>' . __('labels.frontend.auth.login_with', ['social_media' => 'BitBucket']) . '</span></a>';
        // }

        // if (config('services.facebook.active')) {
        //     $socialite_enable[] = '<a href="' . route('frontend.auth.social.login', 'facebook') . '" class="btn btn-brand btn-facebook m-1"><i class="fab fa-facebook"></i> <span>' . __('labels.frontend.auth.login_with', ['social_media' => 'Facebook']) . '</span></a>';
        // }

        // if (config('services.google.active')) {
        //     $socialite_enable[] = '<a href="' . route('frontend.auth.social.login', 'google') . '" class="btn btn-brand btn-google m-1"><i class="fab fa-google"></i> <span>' . __('labels.frontend.auth.login_with', ['social_media' => 'Google']) . '</span></a>';
        // }

        // if (config('services.github.active')) {
        //     $socialite_enable[] = '<a href="' . route('frontend.auth.social.login', 'github') . '" class="btn btn-brand btn-github m-1"><i class="fab fa-github"></i> <span>' . __('labels.frontend.auth.login_with', ['social_media' => 'Github']) . '</span></a>';
        // }

        // if (config('services.linkedin.active')) {
        //     $socialite_enable[] = '<a href="' . route('frontend.auth.social.login', 'linkedin') . '" class="btn btn-brand btn-linkedin m-1"><i class="fab fa-linkedin"></i> <span>' . __('labels.frontend.auth.login_with', ['social_media' => 'LinkedIn']) . '</span></a>';
        // }

        // if (config('services.twitter.active')) {
        //     $socialite_enable[] = '<a href="' . route('frontend.auth.social.login', 'twitter') . '" class="btn btn-brand btn-twitter m-1"><i class="fab fa-twitter"></i> <span>' . __('labels.frontend.auth.login_with', ['social_media' => 'Twitter']) . '</span></a>';
        // }

        // we dont use wechat for a mobile device
        if (config('services.weixinweb.active') && Agent::isDesktop()) {
            $socialite_enable[] = '<a href="'.route('frontend.auth.social.login', 'weixinweb').'" class="btn btn-brand btn-weixin m-1"><i class="fab fa-weixin"></i> <span>'.__('buttons.socialites.weixin').'</span></a>';
        }

        // we use wechat when in weichat browser
        if (config('services.weixin.active') && Agent::isWeChat()) {
            $socialite_enable[] = '<a href="'.route('frontend.auth.social.login', 'weixin').'" class="btn btn-brand btn-weixin m-1"><i class="fab fa-weixin"></i> <span>'.__('buttons.socialites.weixin').'</span></a>';
        }

        if (config('services.qq.active')) {
            $socialite_enable[] = '<a href="'.route('frontend.auth.social.login', 'qq').'" class="btn btn-brand btn-qq m-1"><i class="fab fa-qq"></i> <span>'.__('buttons.socialites.qq').'</span></a>';
        }

        if (config('services.weibo.active')) {
            $socialite_enable[] = '<a href="'.route('frontend.auth.social.login', 'weibo').'" class="btn btn-brand btn-weibo m-1"><i class="fab fa-weibo"></i> <span>'.__('buttons.socialites.weibo').'</span></a>';
        }

        if ($count = count($socialite_enable)) {
            $socialite_links .= '<hr />';
        }

        for ($i = 0; $i < $count; $i++) {
            $socialite_links .= ($socialite_links != '' ? ' ' : '').$socialite_enable[$i];
        }

        return $socialite_links;
    }

    /**
     * List of the accepted third party provider types to login with.
     *
     * @return array
     */
    public function getAcceptedProviders()
    {
        return [
            // 'bitbucket',
            // 'facebook',
            // 'google',
            // 'github',
            // 'linkedin',
            // 'twitter',
            'weixin',
            'weixinweb',
            'qq',
            'weibo',
        ];
    }
}
