<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductosMasVendidosNotification extends Notification
{
    use Queueable;

    protected $productos;
    protected $periodo;

    public function __construct($productos, $periodo = 'mes')
    {
        $this->productos = $productos;
        $this->periodo = $periodo;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $listaProductos = $this->productos->take(3)->pluck('nombre')->implode(', ');
        
        return [
            'titulo' => '🏆 Reporte de Productos Más Vendidos',
            'mensaje' => 'Top 3 productos del ' . $this->periodo . ': ' . $listaProductos,
            'productos' => $this->productos->toArray(),
            'periodo' => $this->periodo,
            'tipo' => 'productos_mas_vendidos',
            'icono' => '📊'
        ];
    }
}