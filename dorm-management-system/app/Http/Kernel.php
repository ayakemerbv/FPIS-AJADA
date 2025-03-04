<?php

namespace App\Http;

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
        'auth' => \App\Http\Middleware\Authenticate::class,

        'admin' => AdminMiddleware::class,

    ];
}
