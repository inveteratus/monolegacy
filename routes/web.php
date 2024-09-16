<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/', 'index')->name('index');
});

Route::middleware(['auth', 'regenerate'])->group(function () {
    Route::view('home', 'home')->name('home');
});
