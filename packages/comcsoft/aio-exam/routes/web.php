<?php

Route::group(['namespace' => 'Comcsoft\Aio\Exam\Controllers', 'middleware' => 'web', 'as' => 'aio-exam::'], function () {
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
        Route::resource('paper', 'PaperController');
        Route::resource('question', 'QuestionController');
    });
});
