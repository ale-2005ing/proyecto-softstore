<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CategoriaCreadaNotification extends Notification
{
    use Queueable;

    protected $categoria;

    public function __construct($categoria)
    {
        $this->categoria = $categoria;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => '📁 Nueva Categoría Creada',
            'mensaje' => 'Se ha creado la categoría: ' . $this->categoria->nombre,
            'categoria_id' => $this->categoria->id,
            'tipo' => 'categoria_creada',
            'icono' => '✅'
        ];
    }
}