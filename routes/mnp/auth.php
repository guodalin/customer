<?php

// All route names are prefixed with 'mnp.auth'.
Route::group([
    'as'        => 'auth.',
    'namespace' => 'Auth',
], function () {
    // 微信小程序登录
    Route::post('login/{name?}', 'LoginController@login')->name('login');
});
