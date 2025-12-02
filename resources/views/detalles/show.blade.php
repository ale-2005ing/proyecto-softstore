@extends('layouts.app')

@section('title', 'Detalles de Entrada')

@section('content')

    {{-- Título --}}
    <div class="flex justify-between items-center mb-6 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
        <h1 class="text-3xl font-bold text-slate-800">
            Detalles de Entrada #{{ $entrada->id }}
        </h1>

        <a href="{{ route('entradas.index') }}"
           class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold shadow-sm 
                  transition-all duration-300 flex items-center gap-2 hover:scale-105 hover:shadow-lg group">

            <svg class="w-5 h-5 transition-transform duration-300 group-hover:-translate-x-1" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                       d="M15 19l-7-7 7-7" />
            </svg>

            Volver
        </a>
    </div>

    {{-- Información general --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 
                opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">

        <p class="text-slate-700 mb-2">
            <strong class="text-slate-800">Proveedor:</strong> 
            {{ $entrada->proveedor->nombre }}
        </p>

        <p class="text-slate-700">
            <strong class="text-slate-800">Fecha:</strong> 
            {{ $entrada->created_at->format('d/m/Y') }}
        </p>
    </div>

    {{-- Tabla --}}
    <div class="w-full overflow-x-auto mt-6">
        <table class="min-w-full table-auto border border-gray-200 rounded-lg">
            <thead class="bg-slate-100 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Producto</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Cantidad</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Precio Compra</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($entrada->detalles as $index => $detalle)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition-all duration-300 
                               opacity-0 hover:scale-[1.01] hover:shadow-sm"
                        style="animation: slideIn 0.4s ease-out {{ 0.1 * ($index + 1) }}s forwards;">
                        
                        <td class="px-6 py-4 text-slate-800 font-medium">
                            {{ $detalle->producto->nombre }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $detalle->cantidad }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            $ {{ number_format($detalle->precio_compra, 2) }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            $ {{ number_format($detalle->subtotal, 2) }}
                        </td>
                    </tr>
                @endforeach
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
    </style>

@endsection
