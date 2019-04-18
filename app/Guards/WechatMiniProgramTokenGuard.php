<?php

namespace App\Guards;

use App\Repositories\Frontend\Wechat\MiniProgramRepository;
use Illuminate\Auth\TokenGuard;

/**
 * 3rd session guard 原理和系统的TokenGuard类似
 * 区别在于接收header中传入的sessionid来识别用户.
 */
class WechatMiniProgramTokenGuard extends TokenGuard
{
    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $token = $this->getTokenForRequest();

        if (! empty($token)) {
            $user = resolve(MiniProgramRepository::class)->findByToken($token);
        }

        return $this->user = $user;
    }

    /**
     * 从header中获得token.
     *
     * @return string
     */
    // protected function getThirdSessionFromRequest()
    // {
    //     return $this->request->header($this->inputKey);
    // }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return ! is_null((new static($this->provider, $this->request, $this->inputKey))->user());
    }
}
