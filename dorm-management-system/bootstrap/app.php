<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\LanguageMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth'  => Authenticate::class,
            'role'  => RoleMiddleware::class,
            'admin' => AdminMiddleware::class,
            'language' => LanguageMiddleware::class,
        ]);
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\LanguageMiddleware::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
//        $middleware->group('web', [
//            LanguageMiddleware::class,
//        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        // Ваши настройки исключений (если нужны)
    })
    ->create();
