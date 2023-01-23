<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'middleware' => ['logger', 'cors']], function () {
    // without middleware auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
        Route::get('/profile', [AuthController::class, 'getprofile'])->middleware('auth');
    });

    Route::group(['middleware' => 'auth'], function () {

    });
});
