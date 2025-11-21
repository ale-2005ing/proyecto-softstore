<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntradaDetalle extends Model
{
    protected $fillable = [
        'entrada_id',
        'producto_id',
        'cantidad',
        'precio_compra',
        'subtotal',
    ];

    public function entrada()
    {
        return $this->belongsTo(Entrada::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}