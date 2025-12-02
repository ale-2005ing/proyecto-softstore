<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // Capturamos el filtro enviado
        $filtro = $request->get('filtro', 'todos');

        // Consultas según el tipo de reporte
        switch ($filtro) {
            case 'bajo':
                $productos = Producto::where('stock', '<=', 10)->get(); // ← Cambiado a 10
                $titulo = 'Productos con Stock Bajo (≤10)';
                break;

            case 'alto':
                $productos = Producto::where('stock', '>=', 50)->get(); // ← Cambiado a 50
                $titulo = 'Productos con Stock Alto (≥50)';
                break;

            case 'mas_vendidos':
                // Productos más vendidos basados en la tabla detalle_ventas
                $productos = Producto::select('productos.*')
                    ->leftJoin('detalle_ventas', 'productos.id', '=', 'detalle_ventas.producto_id')
                    ->selectRaw('productos.*, COALESCE(SUM(detalle_ventas.cantidad), 0) as total_vendido')
                    ->groupBy(
                        'productos.id',
                        'productos.nombre',
                        'productos.descripcion',
                        'productos.precio',
                        'productos.stock',
                        'productos.stock_min',
                        'productos.stock_max',
                        'productos.categoria_id',
                        'productos.proveedor_id',
                        'productos.created_at',
                        'productos.updated_at'
                    )
                    ->orderBy('total_vendido', 'desc')
                    ->having('total_vendido', '>', 0)
                    ->get();
                $titulo = 'Productos Más Vendidos';
                break;

            default:
                $productos = Producto::all();
                $titulo = 'Todos los Productos';
                break;
        }

        return view('reportes.index', compact('productos', 'titulo', 'filtro'));
    }
}