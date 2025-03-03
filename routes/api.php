<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
use App\Http\Controllers\ApiController\ShipController;

Route::apiResource('ships', ShipController::class);


// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('ships', ShipController::class);
// });
