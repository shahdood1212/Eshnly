<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\AuthController;
use App\Http\Controllers\ApiController\ShipController;
use App\Http\Controllers\ApiController\TripController;
use App\Http\Controllers\ApiController\ClientController;
use App\Http\Controllers\ApiController\BookingController;
use App\Http\Controllers\ApiController\Admin\AdminController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);

        Route::get('/clients', [AuthController::class, 'getAllClients']);
        Route::get('/ships', [AuthController::class, 'getAllShips']);
        Route::get('/trips', [AuthController::class, 'getAllTrips']);
        Route::get('/bookings', [AuthController::class, 'getAllBookings']);
    });
});
Route::post('clients/login', [ClientController::class, 'login']);
Route::apiResource('clients', ClientController::class);
Route::apiResource('admins', AdminController::class)->middleware('auth:api');

Route::middleware(['api','auth:clients'])->group(function () {
    Route::apiResource('ships', ShipController::class);
    Route::apiResource('trips', TripController::class);
    Route::apiResource('bookings', BookingController::class);
});
