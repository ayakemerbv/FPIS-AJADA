<?php

namespace App\Http;

use App\Http\Middleware\AdminOrManagerMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\AdminMiddleware;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'role' => RoleMiddleware::class,
        'admin' => AdminMiddleware::class,
        'admin_or_manager' => AdminOrManagerMiddleware::class,

    ];
}
