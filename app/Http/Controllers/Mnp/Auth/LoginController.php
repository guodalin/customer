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
        list($user, $result) = $miniProgramRepository->login($name, $request->input('code'), $request->input('base'));

        if ($user) {
            // Check to see if the users account is confirmed and active
            if (! $user->isConfirmed()) {
                // If the user is pending (account approval is on)
                if ($user->isPending()) {
                    throw new GeneralException(__('exceptions.frontend.auth.confirmation.pending'));
                }

                // Otherwise see if they want to resent the confirmation e-mail
                throw new GeneralException(__('exceptions.frontend.auth.confirmation.resend', [
                    'url' => route('frontend.auth.account.confirm.resend', $user->{$user->getUuidName()}),
                ]));
            } elseif (! $user->isActive()) {
                throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
            }

            return ['message' => __('alerts.frontend.auth.succeed'), 'result' => $result];
        }

        throw new AuthenticationException();
    }
}
