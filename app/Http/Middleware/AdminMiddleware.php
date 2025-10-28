<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado y si su rol es 'admin'
        if (Auth::check() && Auth::user()->rol === 'admin') {
            return $next($request);
        }

        // Si no tiene permisos, lo redirige a la página principal
        return redirect('/');
    }
}
