<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::prefix('login')->group(function () {
        Route::view('', 'auth.login')->name('login');
        Route::post('', LoginController::class);
    });

    Route::prefix('register')->group(function () {
        Route::view('', 'auth.register')->name('register');
        Route::post('', RegisterController::class);
    });

    Route::prefix('forgot-password')->group(function () {
        Route::view('', 'auth.forgot-password')->name('password.recover');
        Route::post('', ForgotPasswordController::class);
    });

    Route::prefix('reset-password')->group(function () {
        Route::view('{token}', 'auth.reset-password')->name('password.reset');
        Route::post('', ResetPasswordController::class)->name('password.reset.store');
    });
});

Route::post('logout', LogoutController::class)->name('logout');
