<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\PlayerListController;
use App\Http\Controllers\RealtorController;
use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/', 'index')->name('index');
});

Route::middleware(['auth', 'regenerate'])->group(function () {
    Route::view('home', 'home')->name('home');
    Route::view('explore', 'explore')->name('explore');
    Route::view('staff', 'staff')->name('staff');
    Route::get('players', PlayerListController::class)->name('players');

    Route::prefix('bank')->group(function () {
        Route::view('', 'bank')->name('bank');
        Route::post('', BankController::class);
    });
    Route::prefix('travel')->group(function () {
        Route::get('', TravelController::class)->name('travel');
        Route::prefix('{city:slug}')->group(function () {
            Route::get('', [TravelController::class, 'details'])->name('travel.details');
            Route::post('', [TravelController::class, 'travel']);
        });
    });
    Route::prefix('realtor')->group(function () {
        Route::get('', RealtorController::class)->name('realtor');
        Route::prefix('{property:slug}')->group(function () {
            Route::get('', [RealtorController::class, 'details'])->name('realtor.details');
            Route::post('', [RealtorController::class, 'purchase'])->name('realtor.purchase');
        });
    });
});
