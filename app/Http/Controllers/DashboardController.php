<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Cliente;

class DashboardController extends Controller
{
    public function index()
    {
        // Contadores generales
        $productos = Producto::count();
        $ventas = Venta::sum('total');
        $clientes = Cliente::count();

        // Actividad reciente
        $ventas_recientes = Venta::latest()->take(5)->get();
        $productos_recientes = Producto::latest()->take(5)->get();
        $clientes_recientes = Cliente::latest()->take(5)->get();

        $actividad = [];

        foreach ($ventas_recientes as $v) {
            $actividad[] = [
                'accion' => 'Nueva venta',
                'detalle' => 'Venta #' . $v->id . ' - Total: $' . $v->total,
                'fecha' => $v->created_at->diffForHumans()
            ];
        }

        foreach ($productos_recientes as $p) {
            $actividad[] = [
                'accion' => 'Producto agregado',
                'detalle' => $p->nombre,
                'fecha' => $p->created_at->diffForHumans()
            ];
        }

        foreach ($clientes_recientes as $c) {
            $actividad[] = [
                'accion' => 'Nuevo cliente',
                'detalle' => $c->nombre,
                'fecha' => $c->created_at->diffForHumans()
            ];
        }

        // Ordenar por fecha descendente
        usort($actividad, function ($a, $b) {
            return strtotime($b['fecha']) - strtotime($a['fecha']);
        });

        $actividad = array_slice($actividad, 0, 10);

        // Datos adicionales para acciones rápidas (solo ejemplo)
        $acciones_rapidas = [
            ['nombre' => 'Registrar venta', 'ruta' => '/ventas'],
            ['nombre' => 'Agregar producto', 'ruta' => '/productos/crear'],
            ['nombre' => 'Buscar cliente', 'ruta' => '/clientes'],
        ];

        return view(
            auth()->user()->rol === 'administrador'
            ? 'dashboard.admin'
            : 'dashboard.empleado',
            compact('productos', 'ventas', 'clientes', 'actividad', 'acciones_rapidas')
        );
    }
}
