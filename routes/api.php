<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\ShipController;
use App\Http\Controllers\ApiController\TripController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Admin\AdminController;

Route::apiResource('ships', ShipController::class);
Route::apiResource('trips', TripController::class);


// Route::middleware('auth:api')->group(function () {
//     Route::apiResource('ships', ShipController::class);
// });
// Route::prefix('auth')->group(function () {
//     Route::post('register', [AuthController::class, 'register']);
//     Route::post('login', [AuthController::class, 'login']);
//     Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');


//     Route::middleware('jwt.auth')->group(function () {
//         Route::post('/logout', [AuthController::class, 'logout']);
//         Route::get('/me', [AuthController::class, 'me']);
//         Route::post('/refresh', [AuthController::class, 'refresh']);
//     });
// });
