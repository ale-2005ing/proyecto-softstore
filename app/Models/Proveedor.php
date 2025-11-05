<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    // ✅ Especificar el nombre correcto de la tabla
    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
        'proveedor_id'
    ];
}

