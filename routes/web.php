<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\AuthController;

// الصفحة الرئيسية
Route::get('/', function () {
    return view('login');
});

// **مسارات السفن (Ships)**
Route::prefix('ships')->group(function () {
    Route::get('/', [ShipController::class, 'index'])->name('web.ships.index'); // تغيير الاسم لتجنب التعارض
    Route::post('/', [ShipController::class, 'store'])->name('web.ships.store');
    Route::get('/create', [ShipController::class, 'create'])->name('web.ships.create');
    Route::get('/{ship}', [ShipController::class, 'show'])->name('web.ships.show');
    Route::put('/{ship}', [ShipController::class, 'update'])->name('web.ships.update');
    Route::delete('/{ship}', [ShipController::class, 'destroy'])->name('web.ships.destroy');
    Route::get('/{ship}/edit', [ShipController::class, 'edit'])->name('web.ships.edit');
});

// **مسارات الحجوزات (Bookings)**
Route::prefix('bookings')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::get('/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::put('/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
});

// **مسارات الرحلات (Trips)**
Route::prefix('trips')->group(function () {
    Route::get('/', [TripController::class, 'index'])->name('trips.index');
    Route::post('/', [TripController::class, 'store'])->name('trips.store');
    Route::get('/create', [TripController::class, 'create'])->name('trips.create');
    Route::get('/{trip}', [TripController::class, 'show'])->name('trips.show');
    Route::put('/{trip}', [TripController::class, 'update'])->name('trips.update');
    Route::delete('/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');
    Route::get('/{trip}/edit', [TripController::class, 'edit'])->name('trips.edit');
});

// **مصادقة المستخدم (Authentication)**
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
