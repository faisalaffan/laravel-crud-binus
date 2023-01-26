<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::group(['prefix' => 'v1'], function () {
    // without middleware auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/reset-password', [AuthController::class, 'resetpassword']);
        Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
        Route::get('/profile', [AuthController::class, 'getprofile']);
    });

    Route::group(['middleware' => 'auth'], function () {

    });
});
