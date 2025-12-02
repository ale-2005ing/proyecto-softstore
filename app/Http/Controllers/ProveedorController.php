<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::latest()->get();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Guardar nuevo proveedor en la base de datos
     * Soporta tanto peticiones normales como AJAX desde modales
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'telefono' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255|regex:/\.com$/i',
            ], [
                'email.regex' => 'El email debe terminar en .com'  // ⬅️ Mensaje personalizado
            ]);

            $proveedor = Proveedor::create([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'email' => $request->email,
            ]);

            // ✅ Si es una petición AJAX (desde el modal), devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'proveedor' => $proveedor,
                    'message' => 'Proveedor creado correctamente.'
                ]);
            }

            // ✅ Si es petición normal, redirigir
            return redirect()->route('proveedores.index')
                ->with('success', 'Proveedor creado correctamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejo de errores de validación
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación: ' . implode(', ', $e->validator->errors()->all())
                ], 422);
            }
            throw $e;

        } catch (\Exception $e) {
            // Manejo de otros errores
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el proveedor: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al crear el proveedor: ' . $e->getMessage());
        }
    }

    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}