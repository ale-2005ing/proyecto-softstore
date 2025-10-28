<?php
//protege la aplicacion contra ataques CSRF (Cross-Site Request Forgery)
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URIs que se excluyen de la verificación CSRF.
     *
     * @var array<int,string>
     */
    protected $except = [
        //
    ];
}
