<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('register', 'AuthController@register');
        Route::post('reset-password', 'AuthController@resetPassword')->name("reset-password");
        Route::get('reset-password-test/{email}', 'AuthController@resetPasswordTest')->name("reset-password-test");
        Route::post('reset-password-confirm', 'AuthController@resetPasswordConfirm')->name("reset-password-confirm");
        // Route::post('set-password', 'UserController@setPassword')->name("set-password");
        Route::post('verify-email', 'AuthController@verifyEmail');
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('logout', 'AuthController@logout');
            Route::post('verify-token', 'AuthController@verifyToken');
        });
    });
    Route::get('test', function () {
        return response()->json(['message' => auth()->user()], 200);
    });
    Route::group(['namespace' => 'App\Http\Controllers'], function () {
        // 
    });
});
