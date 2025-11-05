<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar vista login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $user = $request->user();

    if ($user->rol === 'admin') {
        return redirect()->route('admin.panel');
    }

    if ($user->rol === 'empleado') {
        return redirect()->route('empleado.panel');
    }

    return redirect('/');
}

    /**
     * Cerrar sesión
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
