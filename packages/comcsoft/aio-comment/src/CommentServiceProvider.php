<?php

namespace Comcsoft\Aio\Comment;

use Comcsoft\Aio\Comment\Console\Commands\InstallComment;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/comment.php', 'comment');

        $this->app->bind('aio.comment', CommentManager::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/comment'),
                __DIR__ . '/../config/comment.php' => config_path('comment.php'),
            ], 'aio-comment');

            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->commands([
                InstallComment::class,
            ]);
        }

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'aio-comment');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'aio-comment');

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['aio.comment'];
    }
}
