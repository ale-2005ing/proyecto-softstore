<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))   
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // ✅ Registramos los middlewares correctamente
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class, // ← Cambiado
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class, // ← Cambiado
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class, // ← Cambiado
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();