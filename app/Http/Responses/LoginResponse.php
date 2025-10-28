<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        // Redirigir según el rol del usuario
        if ($user->rol === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->rol === 'empleado') {
            return redirect()->intended('/empleado/dashboard');
        }

        // Si no tiene rol, redirige al dashboard por defecto
        return redirect()->intended('/dashboard');
    }
}

