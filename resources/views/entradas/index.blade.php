@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-900 text-white min-h-screen">

    <h1 class="text-3xl font-bold mb-6">Entradas de Productos</h1>

    <a href="{{ route('entradas.create') }}" 
       class="bg-blue-600 px-4 py-2 rounded font-bold hover:bg-blue-700">
        Nueva Entrada
    </a>

    <table class="w-full mt-6 bg-gray-800 rounded">
        <thead>
            <tr class="border-b border-gray-700">
                <th class="p-3 text-left">ID</th>
                <th class="p-3 text-left">Proveedor</th>
                <th class="p-3 text-left">Fecha</th>
                <th class="p-3 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entradas as $entrada)
                <tr class="border-b border-gray-700">
                    <td class="p-3">{{ $entrada->id }}</td>
                    <td class="p-3">{{ $entrada->proveedor->nombre }}</td>
                    <td class="p-3">{{ $entrada->created_at->format('d/m/Y') }}</td>
                    <td class="p-3">
                        <a href="{{ route('detalles.show', $entrada->id) }}"
                           class="text-blue-400 hover:text-blue-300">
                            Ver Detalles
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
