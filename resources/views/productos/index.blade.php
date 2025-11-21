@extends('layouts.app')

@section('title', 'Productos')

@section('content')

<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl text-white">Productos</h1>

    <a href="{{ route('admin.panel') }}"
       class="bg-gray-700 px-4 py-2 rounded text-white hover:bg-gray-600 transition">
        ← Volver al Dashboard
    </a>
</div>

<a href="{{ route('productos.create') }}"
   class="bg-blue-600 px-4 py-2 rounded text-white hover:bg-blue-500 transition">
    Nuevo producto
</a>

{{-- Filtro de Reportes --}}
<form method="GET" class="flex gap-3 mb-4 mt-4">

    <select name="filtro" class="bg-gray-700 text-white px-4 py-2 rounded">
        <option value="">Todos</option>
        <option value="stock_bajo" {{ ($filtro ?? '') === 'stock_bajo' ? 'selected' : '' }}>
            Stock Bajo (≤ stock_min)
        </option>
        <option value="stock_alto" {{ ($filtro ?? '') === 'stock_alto' ? 'selected' : '' }}>
            Stock Alto (≥ stock_max)
        </option>
        <option value="mas_vendidos" {{ ($filtro ?? '') === 'mas_vendidos' ? 'selected' : '' }}>
            Más Vendidos
        </option>
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Filtrar
    </button>

</form>

{{-- Tabla de productos --}}
<table class="w-full mt-6 border border-gray-700 rounded overflow-hidden">
    <thead class="bg-gray-800 text-blue-400">
        <tr>
            <th class="p-2 text-left">Nombre</th>
            <th class="p-2 text-left">Categoría</th>
            <th class="p-2 text-left">Stock</th>
            <th class="p-2 text-left">Precio</th>
            <th class="p-2 text-left">Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($productos as $item)
        <tr class="border-t border-gray-700">
            <td class="p-2">{{ $item->nombre }}</td>
            <td class="p-2">{{ $item->categoria?->nombre }}</td>
            <td class="p-2">{{ $item->stock }}</td>
            <td class="p-2">${{ number_format($item->precio, 2) }}</td>

            <td class="p-2 flex gap-4">

                <a href="{{ route('productos.edit', $item) }}"
                   class="text-blue-400 hover:underline">
                    Editar
                </a>

                <form action="{{ route('productos.destroy', $item) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar producto?');">
                    @csrf @method('DELETE')
                    <button class="text-red-400 hover:underline">
                        Eliminar
                    </button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
