@extends('layouts.app')

@section('title', 'Productos')

@section('content')

<h1 class="text-2xl mb-4 text-white">Productos</h1>

<a href="{{ route('productos.create') }}"
   class="bg-blue-600 px-4 py-2 rounded text-white hover:bg-blue-500 transition">
    Nuevo producto
</a>

<table class="w-full mt-6 border border-gray-700 rounded overflow-hidden">
    <thead class="bg-gray-800 text-blue-400">
        <tr>
            <th class="p-2 text-left">Nombre</th>
            <th class="p-2 text-left">Categoría</th>
            <th class="p-2 text-left">Proveedor</th>
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
            <td class="p-2">{{ $item->proveedor?->nombre }}</td>
            <td class="p-2">{{ $item->stock }}</td>
            <td class="p-2">${{ $item->precio }}</td>

            <td class="p-2 flex gap-2">

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
