<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

protected $fillable = [
    'nombre',
    'descripcion',  
    'precio',
    'stock',
    'categoria_id',
    'proveedor_id',
    'stock_min',
    'stock_max'
];


    /** Relaciones */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    /** Relación con detalle_ventas */
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id');
    }

    /** ↓↓↓ MÉTODOS PARA MANEJAR STOCK ↓↓↓ */

    // Verificar si hay stock suficiente
    public function tieneStock($cantidad)
    {
        return $this->stock >= $cantidad;
    }

    // Reducir stock al vender
    public function reducirStock($cantidad)
    {
        if (!$this->tieneStock($cantidad)) {
            throw new \Exception("Stock insuficiente para el producto: {$this->nombre}");
        }

        $this->stock -= $cantidad;
        $this->save();
    }

    // Devolver stock cuando se anula una venta
    public function aumentarStock($cantidad)
    {
        $this->stock += $cantidad;
        $this->save();
    }
}
