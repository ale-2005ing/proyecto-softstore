<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductoEliminadoNotification extends Notification
{
    use Queueable;

    protected $nombreProducto;

    public function __construct($nombreProducto)
    {
        $this->nombreProducto = $nombreProducto;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => '🗑️ Producto Eliminado',
            'mensaje' => 'Se ha eliminado el producto: ' . $this->nombreProducto,
            'tipo' => 'producto_eliminado',
            'icono' => '❌'
        ];
    }
}