<?php

namespace Comcsoft\Aio\Exam;

use Comcsoft\Aio\Exam\Composers\QuestionTypeComposer;
use Comcsoft\Aio\Exam\Console\Commands\InstallExam;
use Illuminate\Support\ServiceProvider;

class ExamServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/exam.php', 'aio.exam');

        // register singleton question driver manager
        $this->app->singleton('aio.exam.question', function () {
            return new QuestionManager($this->app);
        });
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
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/aio-exam'),
                __DIR__ . '/../resources/views' => resource_path('views/vendor/aio-exam'),
                __DIR__ . '/../config/exam.php' => config_path('aio/exam.php'),
            ], 'aio-exam');

            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->commands([
                InstallExam::class,
            ]);
        }

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'aio-exam');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'aio-exam');

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // include breadcrumbs file
        require __DIR__ . '/../routes/breadcrumbs.php';

        $this->loadComposers();
    }

    /**
     * load view composers
     *
     * @return void
     */
    public function loadComposers()
    {
        view()->composer('aio-exam::backend.question.includes.search_form', QuestionTypeComposer::class);
    }
}
