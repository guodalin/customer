<?php

namespace App\Providers;

use App\Models\Auth\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/**
 * Class RouteServiceProvider.
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        // Register route model bindings

        // Allow this to select all users regardless of status
        $this->bind('user', function ($value) {
            $user = new User;

            return User::withTrashed()->findByHashid($value);
        });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapMiniProgramRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

        // For the 'Login As' functionality from the 404labfr/laravel-impersonate package
        Route::middleware('web')
            ->group(function (Router $router) {
                $router->impersonate();
            });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "mnp" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapMiniProgramRoutes()
    {
        Route::prefix('mnp')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/mnp.php'));
    }
}
