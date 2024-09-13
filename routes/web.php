<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/', 'index')->name('index');
    Route::view('login', 'login')->name('login');
    Route::post('login', LoginController::class);
    Route::view('register', 'register')->name('register');
    Route::post('register', RegisterController::class);
});

Route::post('logout', LogoutController::class)->name('logout');

Route::middleware('auth')->group(function () {
    Route::view('home', 'home')->name('home');
});
