<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VentaCreadaNotification extends Notification
{
    use Queueable;

    protected $venta;

    public function __construct($venta)
    {
        $this->venta = $venta;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => '💰 Nueva Venta Registrada',
            'mensaje' => 'Venta #' . $this->venta->id . ' - Total: $' . number_format($this->venta->total, 2),
            'venta_id' => $this->venta->id,
            'monto' => $this->venta->total,
            'tipo' => 'venta_creada',
            'icono' => '✅'
        ];
    }
}