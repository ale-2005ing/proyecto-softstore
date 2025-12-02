@extends('layouts.app')

@section('title', 'Detalle del Cliente')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md border border-slate-200 max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold mb-4 text-slate-800">
        Detalles del Cliente
    </h1>

    <div class="space-y-3">

        <div>
            <p class="text-sm text-slate-500">Nombre:</p>
            <p class="text-lg font-semibold text-slate-800">{{ $cliente->nombre }}</p>
        </div>

        <div>
            <p class="text-sm text-slate-500">Teléfono:</p>
            <p class="text-lg text-slate-700">{{ $cliente->telefono }}</p>
        </div>

        <div>
            <p class="text-sm text-slate-500">Email:</p>
            <p class="text-lg text-slate-700">{{ $cliente->email }}</p>
        </div>

        <div>
            <p class="text-sm text-slate-500">Dirección:</p>
            <p class="text-lg text-slate-700">{{ $cliente->direccion }}</p>
        </div>

        <div>
            <p class="text-sm text-slate-500">Estado:</p>
            <span class="px-3 py-1 rounded-lg text-white text-sm font-semibold
                {{ $cliente->estado === 'moroso' ? 'bg-red-600' : 'bg-green-600' }}">
                {{ ucfirst($cliente->estado) }}
            </span>
        </div>

    </div>

    <div class="mt-6 flex justify-between">
        <a href="{{ route('clientes.index') }}"
           class="px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg transition">
            Volver
        </a>

        <a href="{{ route('clientes.edit', $cliente->id) }}"
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
            Editar Cliente
        </a>
    </div>

</div>
@endsection
