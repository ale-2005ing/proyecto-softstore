<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // Capturamos el filtro enviado
        $filtro = $request->get('filtro', 'todos');

        // Consultas según el tipo de reporte
        switch ($filtro) {
            case 'bajo':
                $productos = Producto::where('stock', '<=', 5)->get(); // bajo stock
                $titulo = 'Productos con Stock Bajo';
                break;

            case 'alto':
                $productos = Producto::where('stock', '>=', 100)->get(); // alto stock
                $titulo = 'Productos con Stock Alto';
                break;

            case 'mas_vendidos':
                // Si tienes tabla de ventas, aquí se haría un join o conteo
                $productos = Producto::orderBy('stock', 'asc')->limit(5)->get(); // ejemplo temporal
                $titulo = 'Productos Más Vendidos (ejemplo)';
                break;

            default:
                $productos = Producto::all();
                $titulo = 'Todos los Productos';
                break;
        }

        return view('reportes.index', compact('productos', 'titulo', 'filtro'));
    }
}
