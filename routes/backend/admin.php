<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Menu\MenuController;
use App\Http\Controllers\Backend\Menu\MenuItemController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Menu actions
Route::post('menu/item', [MenuItemController::class, 'store']);
Route::put('menu/item/{item}', [MenuItemController::class, 'update']);
Route::delete('menu/item/{item}', [MenuItemController::class, 'destroy']);
Route::put('menu/item/{item}/swap/{direction}', [MenuItemController::class, 'swap']);

Route::get('menu', [MenuController::class, 'index'])->name('menu.index');
Route::post('menu', [MenuController::class, 'store']);
Route::delete('menu/{menu}', [MenuController::class, 'destroy']);
Route::put('menu/{menu}', [MenuController::class, 'update']);
Route::get('menu/{menu}', [MenuController::class, 'show']);

Route::resource('experts', 'ExpertController');
Route::resource('hospitals', 'ExpertController');
