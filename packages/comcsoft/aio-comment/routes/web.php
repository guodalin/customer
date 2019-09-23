<?php

Route::middleware('web')
    ->namespace('Comcsoft\Aio\Comment\Controllers')
    ->group(function() {
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
