@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Clientes</h1>
        <a href="{{ route('clientes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Nuevo Cliente</a>
    </div>

    @if (session('success'))
        <div class="bg-green-600 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-gray-800 rounded">
        <thead>
            <tr class="text-left text-gray-300">
                <th class="py-2 px-4">ID</th>
                <th class="py-2 px-4">Nombre</th>
                <th class="py-2 px-4">Teléfono</th>
                <th class="py-2 px-4">Email</th>
                <th class="py-2 px-4">Dirección</th>
                <th class="py-2 px-4 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clientes as $cliente)
                <tr class="border-t border-gray-700 hover:bg-gray-700 transition">
                    <td class="py-2 px-4">{{ $cliente->id }}</td>
                    <td class="py-2 px-4">{{ $cliente->nombre }}</td>
                    <td class="py-2 px-4">{{ $cliente->telefono }}</td>
                    <td class="py-2 px-4">{{ $cliente->email }}</td>
                    <td class="py-2 px-4">{{ $cliente->direccion }}</td>
                    <td class="py-2 px-4 text-center">
                        {{-- Botón eliminar --}}
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-400">No hay clientes registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
