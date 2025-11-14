<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Registrar servicios de Fortify.
     */
    public function register(): void
    {
        //
    }

    /**
     * Configurar vistas personalizadas de login y registro.
     */
    public function boot(): void
    {
        // Vista personalizada para login
        Fortify::loginView(function () {
            return view('auth.login');
        });
        

        // Vista personalizada para registro
        Fortify::registerView(function () {
            return view('auth.register');
        });
    }
}

