<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link {{ active_class(Route::is('admin/dashboard')) }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>
            @if ($logged_in_user->id == 1)
            <li class="nav-item">
                <a class="nav-link {{ active_class(Route::is('admin/customer/index')) }}" href="{{ route('admin.customer.index') }}">
                    <i class="nav-icon fab fa-elementor"></i>客服
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ active_class(Route::is('admin/earning/index')) }}"
                    href="{{ route('admin.earning.index') }}">
                    <i class="nav-icon fab fa-elementor"></i>微信号列表
                </a>
            </li>
            @endif
            @if ($logged_in_user->id == 3)
            <li class="nav-item">
                <a class="nav-link {{ active_class(Route::is('admin/dy/index')) }}" href="{{ route('admin.dy.index') }}">
                    <i class="nav-icon fab fa-elementor"></i>兼职
                </a>
            </li>
            @endif

            {{--  <li class="nav-title">@lang('menus.backend.sidebar.app')</li>

            @include('backend.includes.partials.menuitems', ['items' => $app_menus])

            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>

            <li class="nav-item">
                <a class="nav-link {{ active_class(Route::is('admin/menu')) }}" href="{{ route('admin.menu.index') }}">
                    <i class="nav-icon fab fa-elementor"></i>
                    @lang('labels.backend.menu.management')
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ active_class(Route::is('admin/category')) }}" href="{{ route('admin.category.index') }}">
                    <i class="nav-icon fas fa-grip-vertical"></i>
                    @lang('labels.backend.category.management')
                </a>
            </li>

            @if ($logged_in_user->isAdmin())
                <li class="nav-title">
                    @lang('menus.backend.sidebar.system')
                </li>

                <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/auth*'), 'open')
                }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Route::is('admin/auth*')) }}" href="#">
                        <i class="nav-icon far fa-user"></i>
                        @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Route::is('admin/auth/user*')) }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Route::is('admin/auth/role*')) }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown {{ active_class(Route::is('admin/log-viewer*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Route::is('admin/log-viewer*')) }}" href="#">
                        <i class="nav-icon fas fa-list"></i> @lang('menus.backend.log-viewer.main')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Route::is('admin/log-viewer')) }}" href="{{ route('log-viewer::dashboard') }}">
                                @lang('menus.backend.log-viewer.dashboard')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Route::is('admin/log-viewer/logs*')) }}" href="{{ route('log-viewer::logs.list') }}">
                                @lang('menus.backend.log-viewer.logs')
                            </a>
                        </li>
                    </ul>
                </li>
            @endif  --}}
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
