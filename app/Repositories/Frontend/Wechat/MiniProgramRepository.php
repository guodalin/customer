<?php

namespace App\Repositories\Frontend\Wechat;

use App\Exceptions\GeneralException;
use App\Repositories\Frontend\Auth\UserRepository;
use EasyWeChat\Kernel\Exceptions\DecryptException;
use Illuminate\Support\Facades\Cache;
use Overtrue\LaravelWeChat\Facade as Wechat;
use Overtrue\Socialite\User as WechatUser;

class MiniProgramRepository
{
    /**
     * 登录微信小程序.
     *
     * @param string     $name
     * @param string     $code
     * @param array      $base
     * @param array|null $more
     */
    public function login($name, $code, $base, $more = null)
    {
        $mnp = Wechat::miniProgram($name);

        $result = $mnp->auth->session($code);

        $userInfo = $this->decrypt($mnp->encryptor, $result['session_key'], $base['iv'], $base['data']);

        if ($more) {
            $moreInfo = $this->decrypt($mnp->encryptor, $result['session_key'], $more['iv'], $more['data']);
        }

        if ($userInfo) {
            $wechatUser = new WechatUser([
                'id'       => $userInfo['unionId'],
                'nickname' => $userInfo['nickName'],
                'name'     => $userInfo['nickName'],
                'avatar'   => $userInfo['avatarUrl'],
                'email'    => null,
                'token'    => $result['session_key'],
                'provider' => 'weixin',
            ]);

            $user = resolve(UserRepository::class)->findOrCreateProvider($wechatUser, 'weixin');

            $this->cacheToken($result, $user);

            return [$user, $result];
        }
    }

    /**
     * 通过小程序缓存token查找用户.
     *
     * @param  string                     $token
     * @return null|\App\Models\Auth\User
     */
    public function findByToken($token)
    {
        $hashid = Cache::get('wechat.miniprogram.'.$token);

        if (!$hashid) {
            return;
        }

        try {
            return resolve(UserRepository::class)->findByHashid($hashid);
        } catch (GeneralException $e) {
            return;
        }
    }

    /**
     * 解密微信数据.
     *
     * @param  mixed  $encryptor
     * @param  string $sessKey
     * @param  string $iv
     * @param  mixed  $data
     * @return mixed
     */
    protected function decrypt($encryptor, $sessKey, $iv, $data)
    {
        try {
            return $encryptor->decryptData($sessKey, $iv, $data);
        } catch (DecryptException $e) {
            throw new GeneralException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 把用户hashid缓存到微信小程序token.
     *
     * @param  string                $token
     * @param  \App\Models\Auth\User $user
     * @return self
     */
    public function cacheToken($token, $user)
    {
        Cache::put('wechat.miniprogram.'.$token['session_key'], $user->hashid(), now()->addDay());

        return $this;
    }
}
