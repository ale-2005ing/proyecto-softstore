<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable = [
        'user_id',
        'cliente_id',
        'numero',
        'fecha',
        'subtotal',
        'impuesto',
        'total',
        'estado'
    ];

    protected $casts = ['fecha' => 'datetime'];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
