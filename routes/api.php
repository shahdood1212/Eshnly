<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\AuthController;
use App\Http\Controllers\ApiController\ShipController;
use App\Http\Controllers\ApiController\TripController;
use App\Http\Controllers\ApiController\ClientController;
use App\Http\Controllers\Api\Admin\AdminController;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\Authenticate;

Route::middleware(Authenticate::class)->get('/user', function (Request $request) {
    return response()->json($request->user());
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(Authenticate::class)->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
    });
});

Route::apiResource('admins', AdminController::class)->middleware(Authenticate::class);

Route::middleware(Authenticate::class)->group(function () {

    Route::apiResource('ships', ShipController::class);
    Route::apiResource('trips', TripController::class);
    Route::apiResource('clients', ClientController::class);
    
});
