<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\EntradaDetalle;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Categoria;
use Illuminate\Http\Request;

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
        $productos = Producto::orderBy('nombre')->get();
        $categorias = Categoria::all();
        
        return view('entradas.create', compact('proveedores', 'productos', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
        ]);

        // Filtrar solo productos válidos (con todos los datos necesarios)
        $productosValidos = [];
        foreach ($request->productos as $producto) {
            $tieneProducto = !empty($producto['producto_id']) || !empty($producto['nombre']);
            $tieneDatos = !empty($producto['cantidad']) && !empty($producto['precio_compra']);
            
            if ($tieneProducto && $tieneDatos) {
                $productosValidos[] = $producto;
            }
        }

        if (empty($productosValidos)) {
            return back()->withErrors(['productos' => 'Debe agregar al menos un producto válido']);
        }

        // Crear la entrada
        $entrada = Entrada::create([
            'proveedor_id' => $request->proveedor_id,
            'fecha' => now(),
            'total' => 0,
        ]);

        $total = 0;

        // Procesar cada producto
        foreach ($productosValidos as $prod) {
            // Si es un producto existente
            if (!empty($prod['producto_id'])) {
                $producto = Producto::find($prod['producto_id']);
                
                // Actualizar stock
                $producto->stock += $prod['cantidad'];
                
                // Actualizar precio si viene
                if (!empty($prod['precio_venta'])) {
                    $producto->precio = $prod['precio_venta'];
                }
                
                // Actualizar categoría si viene
                if (!empty($prod['categoria_id'])) {
                    $producto->categoria_id = $prod['categoria_id'];
                }
                
                // Actualizar descripción si viene
                if (!empty($prod['descripcion'])) {
                    $producto->descripcion = $prod['descripcion'];
                }
                
                // Actualizar proveedor del producto si viene
                if (!empty($prod['proveedor_producto_id'])) {
                    $producto->proveedor_id = $prod['proveedor_producto_id'];
                }
                
                $producto->save();
                
            } else {
                // Buscar si ya existe un producto con ese nombre
                $producto = Producto::where('nombre', $prod['nombre'])->first();
                
                if ($producto) {
                    // Si existe, solo actualizar el stock
                    $producto->stock += $prod['cantidad'];
                    
                    // Actualizar otros campos si vienen
                    if (!empty($prod['precio_venta'])) {
                        $producto->precio = $prod['precio_venta'];
                    }
                    if (!empty($prod['categoria_id'])) {
                        $producto->categoria_id = $prod['categoria_id'];
                    }
                    if (!empty($prod['descripcion'])) {
                        $producto->descripcion = $prod['descripcion'];
                    }
                    if (!empty($prod['proveedor_producto_id'])) {
                        $producto->proveedor_id = $prod['proveedor_producto_id'];
                    }
                    
                    $producto->save();
                } else {
                    // Si no existe, crear nuevo producto
                    $producto = Producto::create([
                        'nombre' => $prod['nombre'],
                        'descripcion' => $prod['descripcion'] ?? null,
                        'precio' => $prod['precio_venta'] ?? $prod['precio_compra'],
                        'stock' => $prod['cantidad'],
                        'categoria_id' => $prod['categoria_id'] ?? null,
                        'proveedor_id' => $prod['proveedor_producto_id'] ?? $request->proveedor_id,
                        'stock_min' => 1,
                        'stock_max' => 9999,
                    ]);
                }
            }

            // Crear el detalle de entrada
            EntradaDetalle::create([
                'entrada_id' => $entrada->id,
                'producto_id' => $producto->id,
                'cantidad' => $prod['cantidad'],
                'precio_compra' => $prod['precio_compra'],
                'subtotal' => $prod['cantidad'] * $prod['precio_compra'],
            ]);

            // Calcular el total
            $total += $prod['cantidad'] * $prod['precio_compra'];
        }

        // Actualizar el total de la entrada
        $entrada->update(['total' => $total]);

        return redirect()->route('entradas.index')
                         ->with('success', 'Entrada registrada exitosamente con ' . count($productosValidos) . ' producto(s)');
    }

    public function show($id)
    {
        $entrada = Entrada::with(['proveedor', 'detalles.producto'])->findOrFail($id);
        return view('entradas.show', compact('entrada'));
    }

    public function destroy($id)
    {
        $entrada = Entrada::findOrFail($id);
        
        // Restar el stock de los productos
        foreach ($entrada->detalles as $detalle) {
            $producto = $detalle->producto;
            $producto->stock -= $detalle->cantidad;
            $producto->save();
        }
        
        $entrada->delete();
        
        return redirect()->route('entradas.index')
                         ->with('success', 'Entrada eliminada exitosamente');
    }
}