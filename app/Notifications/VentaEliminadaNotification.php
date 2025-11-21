<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VentaEliminadaNotification extends Notification
{
    use Queueable;

    protected $ventaId;
    protected $monto;

    public function __construct($ventaId, $monto)
    {
        $this->ventaId = $ventaId;
        $this->monto = $monto;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => '🗑️ Venta Eliminada',
            'mensaje' => 'Se ha eliminado la venta #' . $this->ventaId . ' por $' . number_format($this->monto, 2),
            'tipo' => 'venta_eliminada',
            'icono' => '❌'
        ];
    }
}