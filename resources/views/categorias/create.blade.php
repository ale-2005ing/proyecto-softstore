@extends('layouts.app')

@section('title', 'Crear Categoría')

@section('content')

<div class="bg-gray-900 flex justify-center px-4 py-10">

    <div class="bg-gray-800 w-full max-w-lg rounded-2xl shadow-lg p-6 mt-4">

        {{-- Título --}}
        <h1 class="text-2xl text-white font-semibold mb-6 text-center">
            Crear Nueva Categoría
        </h1>

        {{-- Botón volver --}}
        <div class="mb-6">
            <a href="{{ route('categorias.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-600 text-white hover:bg-gray-500 transition">
                ⬅ Volver al Listado
            </a>
        </div>

        {{-- Formulario --}}
        <form action="{{ route('categorias.store') }}" method="POST">
            @csrf

            {{-- Nombre --}}
            <div class="mb-6">
                <label class="block text-gray-300 mb-1">Nombre de la Categoría</label>
                <input type="text" name="nombre" required
                       class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white outline-none focus:ring focus:ring-blue-500"
                       placeholder="Escribe el nombre de la categoría">
            </div>

            {{-- Botones --}}
            <div class="flex justify-between">
                <a href="{{ route('categorias.index') }}"
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


