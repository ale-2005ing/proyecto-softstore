<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ClienteEliminadoNotification extends Notification
{
    use Queueable;

    protected $nombreCliente;

    public function __construct($nombreCliente)
    {
        $this->nombreCliente = $nombreCliente;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => '🗑️ Cliente Eliminado',
            'mensaje' => 'Se ha eliminado el cliente: ' . $this->nombreCliente,
            'tipo' => 'cliente_eliminado',
            'icono' => '❌'
        ];
    }
}