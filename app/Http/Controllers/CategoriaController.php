<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\CategoriaCreadaNotification;
use App\Notifications\CategoriaEliminadaNotification;
use Illuminate\Support\Facades\Auth;


class CategoriaController extends Controller
{
    /**
     * Mostrar todas las categorías
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Guardar nueva categoría en la base de datos
     * Soporta tanto peticiones normales como AJAX desde modales
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:categorias,nombre',
            ]);

            $categoria = Categoria::create([
                'nombre' => $request->nombre,
            ]);

            // 🔔 Notificar al usuario autenticado
            auth::user()->notify(new CategoriaCreadaNotification($categoria));

            // 🔔 Opcionalmente, notificar también a todos los administradores
            $admins = User::where('role', 'admin')->get();
            foreach($admins as $admin) {
                if($admin->id !== auth::id()) { // Evitar notificación duplicada
                    $admin->notify(new CategoriaCreadaNotification($categoria));
                }
            }

            // ✅ Si es una petición AJAX (desde el modal), devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'categoria' => $categoria,
                    'message' => '✅ Categoría registrada exitosamente.'
                ]);
            }

            // ✅ Si es petición normal, redirigir
            return redirect()->route('categorias.index')->with('success', '✅ Categoría registrada exitosamente.');

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
                    'message' => 'Error al crear la categoría: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al crear la categoría: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Actualizar categoría existente
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria->update([
            'nombre' => $request->nombre,
        ]);

        // ✅ Redirige con mensaje de éxito
        return redirect()->route('categorias.index')->with('success', '✅ Categoría actualizada correctamente.');
    }

    /**
     * Eliminar categoría
     */
    public function destroy(Categoria $categoria)
    {
        // Guardar el nombre antes de eliminar
        $nombreCategoria = $categoria->nombre;
        
        $categoria->delete();

        // 🔔 Notificar al usuario autenticado
        auth::user()->notify(new CategoriaEliminadaNotification($nombreCategoria));

        // 🔔 Opcionalmente, notificar también a todos los administradores
        $admins = User::where('role', 'admin')->get();
        foreach($admins as $admin) {
            if($admin->id !== auth::id()) { // Evitar notificación duplicada
                $admin->notify(new CategoriaEliminadaNotification($nombreCategoria));
            }
        }

        // ✅ Redirige con mensaje de éxito
        return redirect()->route('categorias.index')->with('success', '🗑️ Categoría eliminada correctamente.');
    }
}