@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Registrar Cliente</h1>

    <form action="{{ route('clientes.store') }}" method="POST" class="max-w-md bg-gray-800 p-6 rounded">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Nombre</label>
            <input type="text" name="nombre" class="w-full px-3 py-2 rounded bg-gray-700 text-white" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Teléfono</label>
            <input type="text" name="telefono" class="w-full px-3 py-2 rounded bg-gray-700 text-white">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Email</label>
            <input type="email" name="email" class="w-full px-3 py-2 rounded bg-gray-700 text-white">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Dirección</label>
            <input type="text" name="direccion" class="w-full px-3 py-2 rounded bg-gray-700 text-white">
        </div>

        <div class="flex justify-between">
            <a href="{{ route('clientes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Volver</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Guardar</button>
        </div>
    </form>
@endsection
