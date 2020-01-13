<?php

namespace App\Http\Composers\Backend;

use App\Helpers\General\MenuHelper;
use App\Repositories\Backend\Auth\UserRepository;
use Illuminate\View\View;
use Lavary\Menu\Facade as MenuFacade;

/**
 * Class SidebarComposer.
 */
class SidebarComposer
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * SidebarComposer constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param View $view
     *
     * @return bool|mixed
     */
    public function compose(View $view)
    {
        if (config('access.users.requires_approval')) {
            $view->with('pending_approval', $this->userRepository->getUnconfirmedCount());
        } else {
            $view->with('pending_approval', 0);
        }

        // build backend menus
        (new MenuHelper())->usingBackendMenu()->build();
        $view->with('app_menus', MenuFacade::get(config('aio.menu.backend'))->roots());
    }
}
