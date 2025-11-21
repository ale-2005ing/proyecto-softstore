<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductoBajoStockNotification extends Notification
{
    use Queueable;

    protected $producto;

    public function __construct($producto)
    {
        $this->producto = $producto;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => '⚠️ Alerta de Stock Bajo',
            'mensaje' => 'El producto "' . $this->producto->nombre . '" tiene solo ' . $this->producto->stock . ' unidades disponibles',
            'producto_id' => $this->producto->id,
            'stock_actual' => $this->producto->stock,
            'tipo' => 'stock_bajo',
            'icono' => '📉'
        ];
    }
}   