<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpleadoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->rol === 'empleado') {
            return $next($request);
        }

        // Si no es empleado, lo redirigimos al inicio
        return redirect('/');
    }
}

