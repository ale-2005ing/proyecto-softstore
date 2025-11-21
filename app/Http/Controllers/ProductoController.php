<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\ProductoCreadoNotification;
use App\Notifications\ProductoEliminadoNotification;
use App\Notifications\ProductoBajoStockNotification;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->input('filtro');

        $query = Producto::query()->with(['categoria', 'proveedor']);

        // 🔵 FILTRO: STOCK BAJO
        if ($filtro === 'stock_bajo') {
            $query->whereColumn('stock', '<=', 'stock_min');
        }

        // 🔵 FILTRO: STOCK ALTO
        if ($filtro === 'stock_alto') {
            $query->whereColumn('stock', '>=', 'stock_max');
        }

        // 🔵 FILTRO: MÁS VENDIDOS
        if ($filtro === 'mas_vendidos') {
            $query->orderBy('ventas_totales', 'desc'); 
        }

        // 🔵 Obtener productos al final SIEMPRE
        $productos = $query->get();

        return view('productos.index', compact('productos', 'filtro'));
    }

    public function create()
    {
    $categorias = Categoria::all();
    $proveedores = Proveedor::all();
    $clientes = \App\Models\Cliente::all(); // ← Agregar esta línea
    
    return view('productos.create', compact('categorias', 'proveedores', 'clientes')); // ← Agregar 'clientes'
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        // 🔎 Buscar si existe un producto con el mismo nombre
        $producto = Producto::where('nombre', $request->nombre)->first();

        if ($producto) {
            // Si ya existe, simplemente actualizamos el stock
            $producto->stock += 1;
            $producto->save();

            // 🔔 Verificar si el stock sigue bajo después de aumentar
            if ($producto->stock <= $producto->stock_min) {
                $admins = User::where('role', 'admin')->get();
                foreach($admins as $admin) {
                    $admin->notify(new ProductoBajoStockNotification($producto));
                }
            }

            return redirect()
                ->route('productos.index')
                ->with('success', 'Stock aumentado del producto existente.');
        }

        // Si NO existe, lo creamos desde cero
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => 1,
            'categoria_id' => $request->categoria_id,
            'proveedor_id' => null,
            'stock_min' => 1,
            'stock_max' => 9999,
        ]);

        // 🔔 Notificar que se creó un nuevo producto
        auth::user()->notify(new ProductoCreadoNotification($producto));

        // 🔔 Notificar también a todos los administradores
        $admins = User::where('role', 'admin')->get();
        foreach($admins as $admin) {
            if($admin->id !== auth::id()) {
                $admin->notify(new ProductoCreadoNotification($producto));
            }
        }

        // 🔔 Verificar si el producto se creó con stock bajo
        if ($producto->stock <= $producto->stock_min) {
            foreach($admins as $admin) {
                $admin->notify(new ProductoBajoStockNotification($producto));
            }
        }

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('productos.edit', compact('producto', 'categorias', 'proveedores'));
    }

    public function update(Request $request, Producto $producto)
    {
        $producto->update($request->all());

        // 🔔 Verificar si el stock está bajo después de actualizar
        if ($producto->stock <= $producto->stock_min) {
            $admins = User::where('role', 'admin')->get();
            foreach($admins as $admin) {
                $admin->notify(new ProductoBajoStockNotification($producto));
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado');
    }

    public function destroy(Producto $producto)
    {
        // Guardar el nombre antes de eliminar
        $nombreProducto = $producto->nombre;
        
        $producto->delete();

        // 🔔 Notificar al usuario autenticado
        auth::user()->notify(new ProductoEliminadoNotification($nombreProducto));

        // 🔔 Notificar también a todos los administradores
        $admins = User::where('role', 'admin')->get();
        foreach($admins as $admin) {
            if($admin->id !== auth::id()) {
                $admin->notify(new ProductoEliminadoNotification($nombreProducto));
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto eliminado');
    }
}