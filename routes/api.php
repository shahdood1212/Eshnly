<?php
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ApiController\AuthController;
// use App\Http\Controllers\ApiController\ShipController;
// use App\Http\Controllers\ApiController\TripController;
// use App\Http\Controllers\ApiController\ClientController;
// use App\Http\Controllers\ApiController\BookingController;
// use App\Http\Controllers\Api\Admin\AdminController;
// use PHPOpenSourceSaver\JWTAuth\Http\Middleware\Authenticate;

// Route::middleware(Authenticate::class)->get('/user', function (Request $request) {
//     return response()->json($request->user());
// });

// Route::prefix('auth')->group(function () {
//     Route::post('/register', [AuthController::class, 'register']);
//     Route::post('/login', [AuthController::class, 'login']);

//     Route::middleware(Authenticate::class)->group(function () {
//         Route::get('/me', [AuthController::class, 'me']);
//         Route::post('/logout', [AuthController::class, 'logout']);
//         Route::post('/refresh', [AuthController::class, 'refresh']);
        
//         Route::get('/clients', [AuthController::class, 'getAllClients']);
//         Route::get('/ships', [AuthController::class, 'getAllShips']);
//         Route::get('/trips', [AuthController::class, 'getAllTrips']);
//         Route::get('/bookings', [AuthController::class, 'getAllBookings']);
   
//     });
// });
// Route::apiResource('clients', controller: ClientController::class);

// Route::apiResource('admins', AdminController::class)->middleware(Authenticate::class);

// Route::middleware(Authenticate::class)->group(function () {

//     Route::apiResource('ships', ShipController::class);
//     Route::apiResource('trips', TripController::class);
//     Route::apiResource('bookings', BookingController::class);});


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\AuthController;
use App\Http\Controllers\ApiController\ShipController;
use App\Http\Controllers\ApiController\TripController;
use App\Http\Controllers\ApiController\ClientController;
use App\Http\Controllers\ApiController\BookingController;
use App\Http\Controllers\Api\Admin\AdminController;

// مسارات المصادقة
Route::prefix('auth')->group(function () {
    // Register and login routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Protected authentication routes
    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
    });
});

// Protected resource routes with JWT authentication
Route::middleware('auth:api')->group(function () {

    Route::apiResource('clients', ClientController::class);
    Route::apiResource('ships', ShipController::class);
    Route::apiResource('trips', TripController::class);
    Route::apiResource('bookings', BookingController::class);

    // Admin-specific resources (optional: role-based)
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('admins', AdminController::class);
    });
});

// Optionally, add a version prefix for API organization
Route::prefix('v1')->middleware('auth:api')->group(function () {
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('ships', ShipController::class);
    Route::apiResource('trips', TripController::class);
    Route::apiResource('bookings', BookingController::class);

    // Admin resource under versioning
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('admins', AdminController::class);
    });
});
