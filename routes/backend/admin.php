<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MenuController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('menu', [MenuController::class, 'index'])->name('menu.index');
