@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="min-h-screen bg-gray-900 flex justify-center items-center px-4 py-8">
    <div class="bg-gray-800 w-full max-w-lg rounded-2xl shadow-lg p-8">
        <h1 class="text-2xl text-white font-semibold mb-6 text-center">
            Crear Nuevo Producto
        </h1>

        <form action="{{ route('productos.store') }}" method="POST">
            @csrf

            {{-- Nombre --}}
            <div class="mb-4">
                <label class="block text-gray-300 mb-1">Nombre</label>
                <input type="text" name="nombre" required
                       class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white outline-none focus:ring focus:ring-blue-500">
            </div>

            {{-- Descripción --}}
            <div class="mb-4">
                <label class="block text-gray-300 mb-1">Descripción</label>
                <textarea name="descripcion" rows="3"
                          class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white outline-none focus:ring focus:ring-blue-500"></textarea>
            </div>

            {{-- Precio --}}
            <div class="mb-4">
                <label class="block text-gray-300 mb-1">Precio</label>
                <input type="number" name="precio" step="0.01" required
                       class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white outline-none focus:ring focus:ring-blue-500">
            </div>

            {{-- Categoría --}}
            <div class="mb-6">
                <label class="block text-gray-300 mb-1">Categoría</label>
                <select name="categoria_id"
                        class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white outline-none focus:ring focus:ring-blue-500">
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('productos.index') }}"
                   class="px-4 py-2 rounded-lg bg-gray-600 text-white hover:bg-gray-500 transition">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-500 transition">
                    Guardar
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
