@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <div class="flex justify-between items-center mb-6 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
        <h1 class="text-3xl font-bold text-slate-800">Clientes</h1>
        <a href="{{ route('clientes.create') }}" 
           class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold shadow-sm transition-all duration-300 flex items-center gap-2 hover:scale-105 hover:shadow-lg group">
            <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Cliente
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-3 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-3 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif
<div class="w-full overflow-x-auto mt-6">
    <table class="min-w-full table-auto border border-gray-200 rounded-lg">
            <thead class="bg-slate-100 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">ID</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Nombre</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Teléfono</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Dirección</th>

                    {{-- NUEVO: ESTADO --}}
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Estado</th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($clientes as $index => $cliente)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition-all duration-300 opacity-0 hover:scale-[1.01] hover:shadow-sm"
                        style="animation: slideIn 0.4s ease-out {{ 0.1 * ($index + 1) }}s forwards;">
                        <td class="px-6 py-4 text-slate-600 font-medium">{{ $cliente->id }}</td>
                        <td class="px-6 py-4 text-slate-800 font-medium">{{ $cliente->nombre }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $cliente->telefono }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $cliente->email }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $cliente->direccion }}</td>

                        {{-- NUEVO: ESTADO DEL CLIENTE --}}
                        <td class="px-6 py-4">
                            @if($cliente->estado === 'activo')
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">Activo</span>
                            @elseif($cliente->estado === 'moroso')
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">Moroso</span>
                            @else
                                <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs">Inactivo</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">

                                <a href="{{ route('clientes.edit', $cliente->id) }}" 
                                   class="text-blue-600 hover:text-blue-700 font-semibold text-sm transition-all duration-300 hover:scale-110 inline-block">
                                    Editar
                                </a>

                                <form action="{{ route('clientes.destroy', $cliente->id) }}" 
                                      method="POST"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-700 font-semibold text-sm transition-all duration-300 hover:scale-110">
                                        Eliminar
                                    </button>
                                </form>

                                {{-- NUEVO: BOTÓN CAMBIAR ESTADO --}}
                                <form action="{{ route('clientes.estado', $cliente->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')

                                    @if($cliente->estado === 'activo')
                                        <button class="text-red-600 hover:text-red-700 font-semibold text-sm transition-all duration-300 hover:scale-110">
                                            Marcar Moroso
                                        </button>
                                    @else
                                        <button class="text-green-600 hover:text-green-700 font-semibold text-sm transition-all duration-300 hover:scale-110">
                                            Activar
                                        </button>
                                    @endif
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-500 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
                                <svg class="w-16 h-16 mb-4 text-slate-300 animate-[pulse_2s_ease-in-out_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="text-lg font-medium mb-1">No hay clientes registrados</p>
                                <p class="text-sm">Comienza agregando tu primer cliente</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    </style>
@endsection
