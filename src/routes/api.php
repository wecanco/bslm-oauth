<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth', 'namespace'=>'BaSalam\Auth\Http\Controllers'], function (){

    Route::get('get-access', 'BaSalamAuthController@userAccess')
        ->name('ba-salam-auth.user_access');

    Route::get('callback', 'BaSalamAuthController@callback')
        ->name('ba-salam-auth.callback');
});

