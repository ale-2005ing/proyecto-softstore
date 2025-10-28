<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\SubstituteBindings;

// 👉 Middlewares globales
use App\Http\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\VerifyCsrfToken;

// 👉 Tus middlewares personalizados
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EmpleadoMiddleware;
use App\Http\Middleware\Authenticate;

class Kernel extends HttpKernel
{
    /**
     * Los middlewares globales se ejecutan en todas las peticiones.
     */
    protected $middleware = [
        // Aquí puedes tener middlewares globales como verificación de mantenimiento, cookies, etc.
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * Los grupos de middleware que puede usar Laravel (web y api).
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Aquí registramos middlewares individuales (de ruta).
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,      // 👈 Middleware del administrador
        'empleado' => \App\Http\Middleware\EmpleadoMiddleware::class, // 👈 Middleware del empleado
    ];
}
