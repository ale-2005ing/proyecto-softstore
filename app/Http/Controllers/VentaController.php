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


class VentaController extends Controller
{
    
    public function index()
    {
        // Obtener todas las ventas paginadas
        $ventas = Venta::with('cliente', 'user')->paginate(10);

        // Retornar vista
        return view('ventas.index', compact('ventas'));
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
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.precio' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $venta = Venta::create([
                'user_id' => Auth::id(),
                'cliente_id' => $request->cliente_id,
                'numero' => 'V-' . time(),
                'fecha' => now(),
                'subtotal' => 0,
                'impuesto' => 0,
                'total' => 0,
                'estado' => 'emitida',
            ]);

            $total = 0;
            $productosConStockBajo = []; // Array para almacenar productos con stock bajo

            foreach ($request->items as $item) {
                $producto = Producto::findOrFail($item['producto_id']);

                // Validar stock
                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para {$producto->nombre}");
                }

                $producto->stock -= $item['cantidad'];
                $producto->save();

                // 🔔 Verificar si el producto quedó con stock bajo después de la venta
                if ($producto->stock <= $producto->stock_min) {
                    $productosConStockBajo[] = $producto;
                }

                $subtotal_item = $item['cantidad'] * $item['precio'];

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                    'subtotal' => $subtotal_item,
                ]);

                $total += $subtotal_item;
            }

            $venta->subtotal = $total;
            $venta->total = $total;
            $venta->save();

            DB::commit();

            // 🔔 Notificar que se creó una nueva venta
            auth::user()->notify(new VentaCreadaNotification($venta));

            // 🔔 Notificar también a administradores y gerentes
            $usuarios = User::whereIn('role', ['admin', 'gerente'])->get();
            foreach($usuarios as $usuario) {
                if($usuario->id !== auth::id()) { // Evitar notificación duplicada
                    $usuario->notify(new VentaCreadaNotification($venta));
                }
            }

            // 🔔 Enviar notificaciones de stock bajo si hay productos afectados
            if (!empty($productosConStockBajo)) {
                $admins = User::where('role', 'admin')->get();
                foreach($productosConStockBajo as $productoConStockBajo) {
                    foreach($admins as $admin) {
                        $admin->notify(new ProductoBajoStockNotification($productoConStockBajo));
                    }
                }
            }

            // Redirigir a la factura recién creada
            return redirect()->route('ventas.factura', $venta->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar la venta: ' . $e->getMessage());
        }
    }

    // Mostrar factura
    public function factura($id)
    {
        $venta = Venta::with('cliente', 'user', 'detalles.producto')->findOrFail($id);
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
            
            // Guardar información antes de eliminar
            $ventaId = $venta->id;
            $monto = $venta->total;
            
            // Restaurar el stock de los productos
            foreach($venta->detalles as $detalle) {
                $producto = Producto::find($detalle->producto_id);
                if($producto) {
                    $producto->stock += $detalle->cantidad;
                    $producto->save();
                }
            }
            
            // Eliminar detalles y venta
            $venta->detalles()->delete();
            $venta->delete();

            DB::commit();

            // 🔔 Notificar al usuario autenticado
            auth::user()->notify(new VentaEliminadaNotification($ventaId, $monto));

            // 🔔 Notificar también a administradores y gerentes
            $usuarios = User::whereIn('role', ['admin', 'gerente'])->get();
            foreach($usuarios as $usuario) {
                if($usuario->id !== auth::id()) {
                    $usuario->notify(new VentaEliminadaNotification($ventaId, $monto));
                }
            }

            return redirect()->route('ventas.index')
                ->with('success', 'Venta eliminada correctamente y stock restaurado');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }
}