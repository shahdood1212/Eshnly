<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware aliases.
     * Use these aliases to assign middleware to routes.
     */
    protected $middlewareAliases = [
        // Middleware الأساسية
        'auth' => \App\Http\Middleware\Authenticate::class,
        'jwt.auth' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
        'jwt.refresh' => \Tymon\JWTAuth\Http\Middleware\RefreshToken::class,

        // Middleware الخاصة
        'clients.auth' => \App\Http\Middleware\ClientAuthMiddleware::class,
    ];
}
