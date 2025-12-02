<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $fillable = [
        'proveedor_id',
        'fecha',
        'total',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Relación uno a muchos con detalles
    public function detalles()
    {
        return $this->hasMany(EntradaDetalle::class);
    }
}