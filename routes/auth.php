<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('login', 'auth.login')->name('login');
    Route::post('login', LoginController::class);
    Route::view('register', 'auth.register')->name('register');
    Route::post('register', RegisterController::class);
});

Route::post('logout', LogoutController::class)->name('logout');
