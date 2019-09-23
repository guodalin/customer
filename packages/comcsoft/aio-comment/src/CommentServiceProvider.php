<?php

namespace Comcsoft\Aio\Comment;

use Comcsoft\Aio\Comment\Console\Commands\InstallComment;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/comment'),
            ], 'aio-comment');
        }

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'aio-comment');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'aio-comment');

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->commands([
            InstallComment::class,
        ]);
    }
}
