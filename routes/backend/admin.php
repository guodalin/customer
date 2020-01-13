<?php

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', 'DashboardController@index')->name('dashboard');

// Menu actions
Route::group(['namespace' => 'Menu'], function () {
    Route::post('menu/item', 'MenuItemController@store');
    Route::put('menu/item/{item}', 'MenuItemController@update');
    Route::delete('menu/item/{item}', 'MenuItemController@destroy');
    Route::put('menu/item/{item}/swap/{direction}', 'MenuItemController@swap');
    Route::apiResource('menu', 'MenuController');
});

// Category actions
Route::put('category/{category}/swap/{direction}', 'CategoryController@swap');
Route::apiResource('category', 'CategoryController');
