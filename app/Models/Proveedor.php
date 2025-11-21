<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    // ✅ Especificar el nombre correcto de la tabla
    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'telefono',
        'email',

    ];

    public function entradas()
    {
        return $this->hasMany(Entrada::class);
    }
}
