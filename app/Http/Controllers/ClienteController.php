<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\ClienteCreadoNotification;
use App\Notifications\ClienteEliminadoNotification;
use Illuminate\Support\Facades\Auth;


class ClienteController extends Controller
{
    /**
     * Mostrar listado de clientes
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Guardar cliente
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'email'       => 'required|email|unique:clientes,email',
            'telefono'    => 'nullable|string|max:30',
            'direccion'   => 'nullable|string|max:255',
        ]);

        $cliente = Cliente::create($request->all());

        // 🔔 Notificar al usuario autenticado
        auth::user()->notify(new ClienteCreadoNotification($cliente));

        // 🔔 Opcionalmente, notificar también a todos los administradores
        $admins = User::where('role', 'admin')->get();
        foreach($admins as $admin) {
            if($admin->id !== auth::id()) { // Evitar notificación duplicada
                $admin->notify(new ClienteCreadoNotification($cliente));
            }
        }

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado correctamente');
    }

    /**
     * Mostrar detalle
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar cliente
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'email'       => 'required|email|unique:clientes,email,' . $cliente->id,
            'telefono'    => 'nullable|string|max:30',
            'direccion'   => 'nullable|string|max:255',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente');
    }

    /**
     * Eliminar cliente
     */
    public function destroy(Cliente $cliente)
    {

    // Bloquear eliminación si está en mora
        if ($cliente->estado === 'moroso') {
        return redirect()->back()
            ->with('error', 'No puedes eliminar un cliente que está en mora.');
    }
    
    // Guardar el nombre antes de eliminar
    $nombreCliente = $cliente->nombre;

    $cliente->delete();

        // Guardar el nombre antes de eliminar
        $nombreCliente = $cliente->nombre;
        
        $cliente->delete();

        // 🔔 Notificar al usuario autenticado
        auth::user()->notify(new ClienteEliminadoNotification($nombreCliente));

        // 🔔 Opcionalmente, notificar también a todos los administradores
        $admins = User::where('role', 'admin')->get();
        foreach($admins as $admin) {
            if($admin->id !== auth::id()) { // Evitar notificación duplicada
                $admin->notify(new ClienteEliminadoNotification($nombreCliente));
            }
        }

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente');
    }
    public function cambiarEstado($id)
{
    $cliente = Cliente::findOrFail($id);

    // lógica de bloqueo
    if ($cliente->estado === 'activo') {
        $cliente->estado = 'moroso';
    } elseif ($cliente->estado === 'moroso') {
        $cliente->estado = 'activo';
    }

    $cliente->save();

    return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }
}