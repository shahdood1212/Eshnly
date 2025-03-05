<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : view('login');
})->name('home');

Route::prefix('ships')->middleware('auth')->group(function () {
    Route::get('/', [ShipController::class, 'index'])->name('ships.index');
    Route::post('/', [ShipController::class, 'store'])->name('ships.store');
    Route::get('/create', [ShipController::class, 'create'])->name('ships.create');
    Route::get('/{ship}', [ShipController::class, 'show'])->name('ships.show');
    Route::put('/{ship}', [ShipController::class, 'update'])->name('ships.update');
    Route::delete('/{ship}', [ShipController::class, 'destroy'])->name('ships.destroy');
    Route::get('/{ship}/edit', [ShipController::class, 'edit'])->name('ships.edit');
});

Route::prefix('bookings')->middleware('auth')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::get('/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::put('/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
});

Route::prefix('trips')->middleware('auth')->group(function () {
    Route::get('/', [TripController::class, 'index'])->name('trips.index');
    Route::post('/', [TripController::class, 'store'])->name('trips.store');
    Route::get('/create', [TripController::class, 'create'])->name('trips.create');
    Route::get('/{trip}', [TripController::class, 'show'])->name('trips.show');
    Route::put('/{trip}', [TripController::class, 'update'])->name('trips.update');
    Route::delete('/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');
    Route::get('/{trip}/edit', [TripController::class, 'edit'])->name('trips.edit');
});
