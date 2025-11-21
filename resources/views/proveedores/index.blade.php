@extends('layouts.app')

@section('content')
<div class="p-8 text-white bg-gray-900 min-h-screen">

    <div class="flex justify-between mb-6">
        <h1 class="text-3xl font-bold">Lista de Proveedores</h1>
        <a href="{{ route('proveedores.create') }}"
           class="bg-blue-600 px-4 py-2 rounded">
            + Nuevo Proveedor
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-600 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full bg-gray-800 rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-gray-700 text-left">
                <th class="p-3">ID</th>
                <th class="p-3">Nombre</th>
                <th class="p-3">Teléfono</th>
                <th class="p-3">Email</th>
                <th class="p-3">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($proveedores as $prov)
            <tr class="border-b border-gray-700">
                <td class="p-3">{{ $prov->id }}</td>
                <td class="p-3">{{ $prov->nombre }}</td>
                <td class="p-3">{{ $prov->telefono }}</td>
                <td class="p-3">{{ $prov->email }}</td>
                <td class="p-3 flex gap-2">

                    <a href="{{ route('proveedores.edit', $prov->id) }}"
                       class="bg-yellow-500 px-3 py-1 rounded">
                        Editar
                    </a>

                    <form action="{{ route('proveedores.destroy', $prov->id) }}" method="POST"
                          onsubmit="return confirm('¿Eliminar proveedor?');">
                        @csrf
                        @method('DELETE')

                        <button class="bg-red-600 px-3 py-1 rounded">
                            Eliminar
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
