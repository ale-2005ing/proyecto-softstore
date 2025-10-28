<?php
//protege o cifra las cookies de la aplicacion
namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * Las cookies que NO se deben encriptar.
     *
     * @var array<int,string>
     */
    protected $except = [
        //
    ];
}
