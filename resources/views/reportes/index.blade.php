@extends('layouts.app')

@section('title', 'Reportes de Inventario')

@section('content')
<div class="min-h-screen bg-gray-900 text-white px-6 py-8">
    <div class="max-w-6xl mx-auto bg-gray-800 p-6 rounded-2xl shadow-lg">

        <h1 class="text-2xl font-semibold mb-6 text-center">{{ $titulo }}</h1>

        {{-- Filtro --}}
        <form method="GET" action="{{ route('reportes.index') }}" class="mb-6 flex justify-center space-x-4">
            <select name="filtro" class="px-4 py-2 bg-gray-700 rounded-lg text-white">
                <option value="todos" {{ $filtro === 'todos' ? 'selected' : '' }}>Todos</option>
                <option value="bajo" {{ $filtro === 'bajo' ? 'selected' : '' }}>Stock Bajo (≤10)</option>
                <option value="alto" {{ $filtro === 'alto' ? 'selected' : '' }}>Stock Alto (≥100)</option>
                <option value="mas_vendidos" {{ $filtro === 'mas_vendidos' ? 'selected' : '' }}>Más Vendidos</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-lg">
                Filtrar
            </button>
        </form>

        {{-- Tabla --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-700 text-gray-300">
                    <tr>
                        <th class="py-2 px-4 text-left">ID</th>
                        <th class="py-2 px-4 text-left">Nombre</th>
                        <th class="py-2 px-4 text-left">Descripción</th>
                        <th class="py-2 px-4 text-left">Precio</th>
                        <th class="py-2 px-4 text-left">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr class="border-b border-gray-700 hover:bg-gray-700">
                            <td class="py-2 px-4">{{ $producto->id }}</td>
                            <td class="py-2 px-4">{{ $producto->nombre }}</td>
                            <td class="py-2 px-4">{{ $producto->descripcion }}</td>
                            <td class="py-2 px-4">${{ number_format($producto->precio, 2) }}</td>
                            <td class="py-2 px-4">{{ $producto->stock }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-400">No hay productos en este reporte.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
