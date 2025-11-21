<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductoCreadoNotification extends Notification
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
            'titulo' => '✅ Nuevo Producto Creado',
            'mensaje' => 'Se ha creado el producto: ' . $this->producto->nombre . ' - Stock: ' . $this->producto->stock,
            'producto_id' => $this->producto->id,
            'tipo' => 'producto_creado',
            'icono' => '📦'
        ];
    }
}