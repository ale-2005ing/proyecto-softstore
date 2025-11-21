<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CategoriaEliminadaNotification extends Notification
{
    use Queueable;

    protected $nombreCategoria;

    public function __construct($nombreCategoria)
    {
        $this->nombreCategoria = $nombreCategoria;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => '🗑️ Categoría Eliminada',
            'mensaje' => 'Se ha eliminado la categoría: ' . $this->nombreCategoria,
            'tipo' => 'categoria_eliminada',
            'icono' => '❌'
        ];
    }
}