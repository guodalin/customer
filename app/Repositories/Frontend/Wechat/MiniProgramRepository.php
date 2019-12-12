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
     * @var \EasyWeChat\MiniProgram\Application
     */
    public $mnp;

    /**
     * @var string
     */
    public $sessKey;

    /**
     * init mnp app
     *
     * @param string|null $name
     * @return self
     */
    public function init($name)
    {
        $this->mnp = Wechat::miniProgram($name);

        return $this;
    }

    /**
     * 设置session_key
     *
     * @param string $sessKey
     * @return self
     */
    public function setSessionKey($sessKey)
    {
        $this->sessKey = $sessKey;

        return $this;
    }

    /**
     * 换取session_key
     *
     * @param string $code
     * @return self
     */
    public function auth($code)
    {
        $result = $this->mnp->auth->session($code);

        $this->setSessionKey($result['session_key']);

        return $this;
    }

    /**
     * 登录微信小程序.
     *
     * @param array      $base
     * @param array|null $more
     */
    public function login($base, $more = null)
    {
        $userInfo = $this->decrypt($this->mnp->encryptor, $this->sessKey, $base['iv'], $base['data']);

        if ($more) {
            $moreInfo = $this->decrypt($this->mnp->encryptor, $this->sessKey, $more['iv'], $more['data']);
        }

        if ($userInfo) {
            $wechatUser = new WechatUser([
                'id'       => $userInfo['unionId'] ?? $userInfo['openId'],
                'nickname' => $userInfo['nickName'],
                'name'     => $userInfo['nickName'],
                'avatar'   => $userInfo['avatarUrl'],
                'email'    => null,
                'token'    => $this->sessKey,
                'provider' => 'wechat',
            ]);

            return resolve(UserRepository::class)->findOrCreateProvider(
                $wechatUser,
                'wechat',
                isset($moreInfo) ? $moreInfo['phoneNumber'] : null);
        }
    }

    /**
     * 通过小程序缓存token查找用户.
     *
     * @param  string                     $token
     * @return null|\App\Models\Auth\User
     */
    public function user()
    {
        $hashid = Cache::get('wechat.miniprogram.'.$this->sessKey);

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
    public function store($user)
    {
        Cache::put('wechat.miniprogram.'.$this->sessKey, $user->hashid(), now()->addDay());

        return $this;
    }
}
