<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\EntradaDetalle;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Proveedor;

class EntradaController extends Controller
{
    public function index()
    {
        $entradas = Entrada::with('proveedor')->latest()->get();
        return view('entradas.index', compact('entradas'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        return view('entradas.create', compact('proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_compra' => 'required|numeric|min:0',
        ]);

        // Crear la entrada
        $entrada = Entrada::create([
        'proveedor_id' => $request->proveedor_id,
        'fecha' => now(),
        ]);

        foreach ($request->productos as $item) {

            $producto = Producto::find($item['producto_id']);

            // Aumentar stock
            $producto->increment('stock', $item['cantidad']);

            // Guardar detalle
            EntradaDetalle::create([
            'entrada_id' => $entrada->id,
            'producto_id' => $producto->id,
            'cantidad' => $item['cantidad'],
            'precio_compra' => $item['precio_compra'],
            'subtotal' => $item['cantidad'] * $item['precio_compra'],
            ]);
        }

        return redirect()->route('entradas.index')
            ->with('success', 'Entrada registrada exitosamente.');
    }
}
