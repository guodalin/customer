<?php

Route::group(['namespace' => 'Comcsoft\Aio\Comment\Controllers', 'middleware' => 'web', 'as' => 'aio-comment::'], function () {
        /*
        * Frontend Routes
        * Namespaces indicate folder structure
        */
        Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
        });

        /*
        * Backend Routes
        * Namespaces indicate folder structure
        */
        Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
            Route::resource('comment', 'CommentController');
        });
    });
