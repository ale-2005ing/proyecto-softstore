<?php
namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\VentaCreadaNotification;
use App\Notifications\VentaEliminadaNotification;
use App\Notifications\ProductoBajoStockNotification;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cliente;


class VentaController extends Controller
{
    
    public function index()
    {
        // Obtener todas las ventas paginadas
        $ventas = Venta::with('cliente', 'user')->paginate(10);

        // Retornar vista
        return view('ventas.index', compact('ventas'));
    }
      public function edit($id)
    {
        $venta = Venta::with(['detalles.producto', 'cliente'])->findOrFail($id);
        
        // Verificar que la venta no esté cancelada
        if ($venta->estado === 'cancelada') {
            return redirect()->route('ventas.show', $venta->id)
                ->with('error', 'No se puede editar una venta cancelada');
        }
        
        $productos = Producto::where('estado', 'activo')
            ->orderBy('nombre')
            ->get();
            
        $clientes = Cliente::where('estado', 'activo')
            ->orderBy('nombre')
            ->get();
        
        return view('ventas.edit', compact('venta', 'productos', 'clientes'));
    }

    // Mostrar formulario de venta
    public function create()
    {
        $clientes = \App\Models\Cliente::all();
        $productos = Producto::all();

        return view('ventas.create', compact('clientes', 'productos'));
    }

    // Guardar venta con detalle
public function store(Request $request)
{
    try {
        // Validación
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        // Generar número de venta único
        $ultimaVenta = Venta::latest('id')->first();
        $numeroVenta = $ultimaVenta ? 'V-' . str_pad($ultimaVenta->id + 1, 6, '0', STR_PAD_LEFT) : 'V-000001';

        // Crear la venta
        $venta = new Venta();
        $venta->numero = $numeroVenta;
        $venta->cliente_id = $request->cliente_id ? $request->cliente_id : null; // null para consumidor final
        $venta->user_id = Auth::id(); // Usuario autenticado
        $venta->fecha = now();
        $venta->subtotal = 0;
        $venta->impuesto = 0;
        $venta->total = 0;
        $venta->estado = 'completada';
        $venta->save();

        $subtotal = 0;

        // Procesar cada producto
        foreach ($request->productos as $prod) {
            $producto = Producto::findOrFail($prod['id']);
            
            // Verificar stock disponible
            if ($producto->stock < $prod['cantidad']) {
                throw new \Exception("Stock insuficiente para: {$producto->nombre}. Disponible: {$producto->stock}");
            }

            $cantidad = $prod['cantidad'];
            $precioUnitario = $producto->precio;
            $subtotalItem = $precioUnitario * $cantidad;
            $subtotal += $subtotalItem;

            // Crear detalle de venta
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'precio' => $precioUnitario,
                'subtotal' => $subtotalItem,
            ]);

            // Reducir stock del producto
            $producto->decrement('stock', $cantidad);
        }

        // Calcular impuesto y total (ajusta el porcentaje según tu país)
        $impuesto = $subtotal * 0.19; // 19% de IVA
        $total = $subtotal + $impuesto;

        // Actualizar totales en la venta
        $venta->update([
            'subtotal' => $subtotal,
            'impuesto' => $impuesto,
            'total' => $total,
        ]);

        DB::commit();

        // Redirigir directamente a la factura
        return redirect()
            ->route('ventas.show', $venta->id)
            ->with('success', 'Venta registrada exitosamente');

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return back()
            ->withErrors($e->errors())
            ->withInput()
            ->with('error', 'Por favor verifica los datos ingresados');
            
    } catch (\Exception $e) {
        DB::rollBack();
        return back()
            ->withInput()
            ->with('error', 'Error al registrar la venta: ' . $e->getMessage());
    }
}
    public function show($id)
{
    $venta = Venta::with(['cliente', 'user', 'detalles.producto'])
        ->findOrFail($id);

    return view('ventas.show', compact('venta'));
}

    // Mostrar factura
    public function factura(Venta $venta)
    {
    $venta->load('cliente', 'user', 'detalles.producto');
    return view('ventas.factura', compact('venta'));
    }

public function pdf($id)
{
    $venta = Venta::with(['cliente', 'user', 'detalles.producto'])->findOrFail($id);
    
    $pdf = Pdf::loadView('ventas.factura_pdf', compact('venta'));
    
    return $pdf->download('factura_' . $venta->numero . '.pdf');
}

public function verPdf($id)
{
    $venta = Venta::with(['cliente', 'user', 'detalles.producto'])->findOrFail($id);
    
    $pdf = Pdf::loadView('ventas.factura_pdf', compact('venta'));
    
    return $pdf->stream('factura_' . $venta->numero . '.pdf');
}
    // Eliminar venta
   public function destroy($id)
{
    DB::beginTransaction();
    
    try {
        $venta = Venta::with('detalles')->findOrFail($id);
        
        // Restaurar el stock de los productos
        foreach ($venta->detalles as $detalle) {
            $producto = $detalle->producto;
            $producto->stock += $detalle->cantidad;
            $producto->save();
        }
        
        // Eliminar los detalles primero
        $venta->detalles()->delete();
        
        // Eliminar la venta
        $venta->delete();
        
        DB::commit();
        
        return redirect()->route('ventas.index')
            ->with('success', 'Venta eliminada y stock restaurado exitosamente');
            
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    } 
}