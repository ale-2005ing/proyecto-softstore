@extends('layouts.app')

@section('title', 'Reportes de Inventario')

@section('content')
<div class="max-w-6xl mx-auto">
    
    <div class="flex justify-between items-center mb-6 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">{{ $titulo }}</h1>
            <p class="text-slate-600 mt-1">Análisis y estadísticas del inventario</p>
        </div>
    </div>
    
    {{-- Filtro --}}
    <form method="GET" action="{{ route('reportes.index') }}" 
          class="mb-6 flex flex-col sm:flex-row gap-3 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
        <select name="filtro" 
                class="flex-1 px-4 py-2.5 bg-white text-slate-800 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none font-medium transition-all duration-300 hover:border-slate-400">
            <option value="todos" {{ $filtro === 'todos' ? 'selected' : '' }}>📊 Todos los productos</option>
            <option value="bajo" {{ $filtro === 'bajo' ? 'selected' : '' }}>🔴 Stock Bajo (≤10)</option>
            <option value="alto" {{ $filtro === 'alto' ? 'selected' : '' }}>🟢 Stock Alto (≥50)</option>
            <option value="mas_vendidos" {{ $filtro === 'mas_vendidos' ? 'selected' : '' }}>⭐ Más Vendidos</option>
        </select>
        <button type="submit" 
                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg">
            Filtrar
        </button>
    </form>
    
    {{-- Tabla --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden opacity-0 animate-[fadeInUp_0.6s_ease-out_0.4s_forwards] hover:shadow-md transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100 border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-slate-700">ID</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-slate-700">Nombre</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-slate-700">Descripción</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-slate-700">Precio</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-slate-700">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $index => $producto)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-all duration-300 opacity-0 hover:scale-[1.01]"
                            style="animation: slideIn 0.4s ease-out {{ 0.1 * ($index + 1) }}s forwards;">
                            <td class="py-4 px-6 text-slate-600 font-medium">{{ $producto->id }}</td>
                            <td class="py-4 px-6 text-slate-800 font-medium">{{ $producto->nombre }}</td>
                            <td class="py-4 px-6 text-slate-600">{{ $producto->descripcion }}</td>
                            <td class="py-4 px-6 text-slate-800 font-semibold">${{ number_format($producto->precio, 2) }}</td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold transition-all duration-300 hover:scale-105 inline-block
                                    @if($producto->stock <= 10)
                                        bg-red-100 text-red-700 animate-pulse
                                    @elseif($producto->stock >= 100)
                                        bg-green-100 text-green-700
                                    @else
                                        bg-amber-100 text-amber-700
                                    @endif">
                                    {{ $producto->stock }} unidades
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-500 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
                                    <svg class="w-16 h-16 mb-4 text-slate-300 animate-[pulse_2s_ease-in-out_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-lg font-medium mb-1">No hay productos en este reporte</p>
                                    <p class="text-sm">Intenta con otro filtro</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Resumen estadístico --}}
    @if($productos->count() > 0)
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.6s_forwards]">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Total Productos</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $productos->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Valor Total</p>
                    <p class="text-2xl font-bold text-slate-800">${{ number_format($productos->sum(fn($p) => $p->precio * $p->stock), 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Stock Total</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $productos->sum('stock') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<style>
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}
</style>

@endsection