<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\PembeliController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;

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
        Route::group(['prefix' => 'staff'], function () {
            Route::post('/', [StaffController::class, 'registerstaff']);
            Route::get('/', [StaffController::class, 'read']);
            Route::put('/', [StaffController::class, 'update']);
            Route::delete('/', [StaffController::class, 'delete']);
        });

        Route::group(['prefix' => 'pembeli'], function () {
            Route::post('/', [PembeliController::class, 'registerpembeli']);
            Route::get('/', [PembeliController::class, 'read']);
            Route::put('/', [PembeliController::class, 'update']);
            Route::delete('/', [PembeliController::class, 'delete']);
        });

        Route::group(['prefix' => 'barang'], function () {
            Route::post('/', [BarangController::class, 'create']);
            Route::get('/', [BarangController::class, 'read']);
            Route::put('/', [BarangController::class, 'update']);
            Route::delete('/', [BarangController::class, 'delete']);
        });
    });
});
