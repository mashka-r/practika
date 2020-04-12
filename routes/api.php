<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'API\RegisterController@register');
Route::post('/login', 'API\LogController@login');
Route::middleware('auth:api')->group(function () {
    Route::get('/logout', 'API\LogController@logout');
});

Route::group(['prefix' => 'admin'], function() {
    Route::post('/login', 'API\LogController@login');
    Route::middleware('auth:api')->group(function () {
        Route::get('/show/{id?}', 'API\UserController@show');
        Route::get('/logout', 'API\LogController@logout');
});
});