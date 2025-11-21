<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ClienteCreadoNotification extends Notification
{
    use Queueable;

    protected $cliente;

    public function __construct($cliente)
    {
        $this->cliente = $cliente;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => '👤 Nuevo Cliente Registrado',
            'mensaje' => 'Cliente: ' . $this->cliente->nombre . ' - Email: ' . ($this->cliente->email ?? 'Sin email'),
            'cliente_id' => $this->cliente->id,
            'tipo' => 'cliente_creado',
            'icono' => '✅'
        ];
    }
}