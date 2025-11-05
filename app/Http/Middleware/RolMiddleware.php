<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $rol)
    {
        if (!$request->user() || $request->user()->rol !== $rol) {
            abort(403, 'NO TIENES PERMISO PARA INGRESAR AQUÍ');
        }

        return $next($request);
    }
}
