<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
     
    if (!$request->user()) {
        return redirect('/login');
    }

    if ($role && $request->user()->role !== $role) {
        return abort(403, 'NO TIENES PERMISO PARA INGRESAR AQUÍ');
    }

    return $next($request);
    }
}
