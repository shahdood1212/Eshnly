<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
Route::get('/', function () {
    return redirect()->route('login.form');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::view('/layout', 'layout')->name('layout');

Route::middleware(['auth'])->group(function () {
    Route::resource('ships', ShipController::class);
    Route::resource('trips', TripController::class);
    Route::resource('Booking', BookingController::class);
    Route::resource('trips', ClientController::class);
    Route::resource('Transaction', TransactionController::class);
    Route::resource('Wallet', WalletController::class);
});

// use App\Http\Controllers\ShipController;

// Route::resource('ships', ShipController::class);


// Route::resource('trips', TripController::class);

