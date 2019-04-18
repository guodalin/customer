<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| MNP Routes
|--------------------------------------------------------------------------
|
| Here is where you can register MNP routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:mnp')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * MNP Routes
 * Namespaces indicate folder structure
 */

Route::group(['namespace' => 'Mnp', 'as' => 'mnp.'], function () {
    include_route_files(__DIR__.'/mnp/');
});
