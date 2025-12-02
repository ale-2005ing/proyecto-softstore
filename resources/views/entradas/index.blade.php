@extends('layouts.app')

@section('title', 'Entradas de Productos')

@section('content')

    {{-- Título y botón --}}
    <div class="flex justify-between items-center mb-6 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
        <h1 class="text-3xl font-bold text-slate-800">Entradas de Productos</h1>

        <a href="{{ route('entradas.create') }}" 
           class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold shadow-sm transition-all duration-300 flex items-center gap-2 hover:scale-105 hover:shadow-lg group">
            
            <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>

            Nueva Entrada
        </a>
    </div>

    {{-- Tabla --}}
    <div class="w-full overflow-x-auto mt-6">
        <table class="min-w-full table-auto border border-gray-200 rounded-lg">
            <thead class="bg-slate-100 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">ID</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Proveedor</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Fecha</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($entradas as $index => $entrada)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition-all duration-300 opacity-0 hover:scale-[1.01] hover:shadow-sm"
                        style="animation: slideIn 0.4s ease-out {{ 0.1 * ($index + 1) }}s forwards;">

                        <td class="px-6 py-4 text-slate-600 font-medium">{{ $entrada->id }}</td>
                        <td class="px-6 py-4 text-slate-800 font-medium">{{ $entrada->proveedor->nombre }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $entrada->created_at->format('d/m/Y') }}</td>

                        <td class="px-6 py-4">
                            <a href="{{ route('detalles.show', $entrada->id) }}"
                               class="text-blue-600 hover:text-blue-700 font-semibold text-sm transition-all duration-300 hover:scale-110 inline-block">
                                Ver Detalles
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-500 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
                                <svg class="w-16 h-16 mb-4 text-slate-300 animate-[pulse_2s_ease-in-out_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="text-lg font-medium mb-1">No hay entradas registradas</p>
                                <p class="text-sm">Comienza agregando una nueva entrada</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Animaciones --}}
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
