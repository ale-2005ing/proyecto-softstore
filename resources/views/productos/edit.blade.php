@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="min-h-screen bg-gray-900 flex justify-center items-center px-4 py-8">
    <div class="bg-gray-800 w-full max-w-lg rounded-2xl shadow-lg p-8">
        <h1 class="text-2xl text-white font-semibold mb-6 text-center">
            Editar Producto
        </h1>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="mb-4 text-green-400 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('productos.update', $producto->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="mb-4">
                <label class="block text-gray-300 mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" 
                       required pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                       class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white outline-none focus:ring focus:ring-blue-500">
                @error('nombre')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descripción --}}
            <div class="mb-4">
                <label class="block text-gray-300 mb-1">Descripción</label>
                <textarea name="descripcion" rows="3" maxlength="100" required
                          class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white outline-none focus:ring focus:ring-blue-500"
                          placeholder="Máx. 100 caracteres">{{ old('descripcion', $producto->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Precio --}}
            <div class="mb-4">
                <label class="block text-gray-300 mb-1">Precio</label>
                <input type="number" name="precio" step="0.01"
                       value="{{ old('precio', $producto->precio) }}" required
                       class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white outline-none focus:ring focus:ring-blue-500">
                @error('precio')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Categoría --}}
            <div class="mb-6">
                <label class="block text-gray-300 mb-1">Categoría</label>
                <select name="categoria_id"
                        class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white outline-none focus:ring focus:ring-blue-500">

                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach

                </select>
                @error('categoria_id')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Acciones --}}
            <div class="flex justify-between">
                <a href="{{ route('productos.index') }}"
                   class="px-4 py-2 rounded-lg bg-gray-600 text-white hover:bg-gray-500 transition">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-500 transition">
                    Actualizar
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
