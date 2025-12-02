@extends('layouts.app')

@section('title', 'Panel de Empleado')

@section('content')
<div class="max-w-7xl mx-auto">
    
    {{-- Encabezado --}}
    <div class="mb-8 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
        <h1 class="text-3xl font-bold text-slate-800">Panel de Empleado</h1>
        <p class="text-slate-600 mt-2">Bienvenido, {{ auth()->user()->name }}</p>
    </div>

    {{-- Acciones Rápidas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        
        {{-- Crear Nueva Venta --}}
        <a href="{{ route('ventas.create') }}" 
           class="bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-6 rounded-xl shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards] group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Nueva Venta</h3>
            <p class="text-blue-100 text-sm">Crear una nueva venta y generar factura</p>
        </a>

        {{-- Ver Productos --}}
        <a href="{{ route('productos.index') }}" 
           class="bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-6 rounded-xl shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl opacity-0 animate-[fadeInUp_0.6s_ease-out_0.3s_forwards] group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Ver Productos</h3>
            <p class="text-green-100 text-sm">Consultar catálogo, precios y stock</p>
        </a>

        {{-- Mis Ventas --}}
        <a href="{{ route('ventas.index') }}" 
           class="bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-6 rounded-xl shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl opacity-0 animate-[fadeInUp_0.6s_ease-out_0.4s_forwards] group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Mis Ventas</h3>
            <p class="text-purple-100 text-sm">Ver historial de ventas realizadas</p>
        </a>

        {{-- Buscar Clientes --}}
        <a href="{{ route('clientes.index') }}" 
           class="bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white p-6 rounded-xl shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl opacity-0 animate-[fadeInUp_0.6s_ease-out_0.5s_forwards] group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Buscar Clientes</h3>
            <p class="text-orange-100 text-sm">Consultar información de clientes</p>
        </a>

        {{-- Generar Factura --}}
        <a href="{{ route('ventas.create') }}" 
           class="bg-gradient-to-br from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white p-6 rounded-xl shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl opacity-0 animate-[fadeInUp_0.6s_ease-out_0.6s_forwards] group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Generar Factura</h3>
            <p class="text-red-100 text-sm">Crear y descargar facturas</p>
        </a>

        {{-- Ayuda --}}
        <a href="" 
           onclick="mostrarAyuda(); return false;"
           class="bg-gradient-to-br from-slate-500 to-slate-600 hover:from-slate-600 hover:to-slate-700 text-white p-6 rounded-xl shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl opacity-0 animate-[fadeInUp_0.6s_ease-out_0.7s_forwards] group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">Ayuda</h3>
            <p class="text-slate-100 text-sm">Guía de uso y soporte</p>
        </a>
    </div>

    {{-- Estadísticas del día --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.8s_forwards]">
        <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Mis Estadísticas de Hoy
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Ventas del día --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center gap-3 mb-2">
                    <div class="bg-blue-500 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-blue-600 font-semibold uppercase">Ventas Hoy</p>
                        <p class="text-2xl font-bold text-blue-800">
                            {{ \App\Models\Venta::where('user_id', auth()->id())->whereDate('created_at', today())->count() }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Total vendido --}}
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center gap-3 mb-2">
                    <div class="bg-green-500 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-green-600 font-semibold uppercase">Total Vendido</p>
                        <p class="text-2xl font-bold text-green-800">
                            ${{ number_format(\App\Models\Venta::where('user_id', auth()->id())->whereDate('created_at', today())->sum('total'), 2) }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Última venta --}}
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <div class="flex items-center gap-3 mb-2">
                    <div class="bg-purple-500 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-purple-600 font-semibold uppercase">Última Venta</p>
                        <p class="text-lg font-bold text-purple-800">
                            @php
                                $ultimaVenta = \App\Models\Venta::where('user_id', auth()->id())->latest()->first();
                            @endphp
                            @if($ultimaVenta)
                                {{ $ultimaVenta->created_at->diffForHumans() }}
                            @else
                                Sin ventas aún
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Información importante --}}
    <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 opacity-0 animate-[fadeInUp_0.6s_ease-out_1s_forwards]">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-amber-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="font-bold text-amber-800 mb-2">Información Importante</h3>
                <ul class="text-sm text-amber-700 space-y-1">
                    <li>✓ Puedes crear ventas y generar facturas</li>
                    <li>✓ Consulta productos, precios y stock disponible</li>
                    <li>✓ Busca clientes para asociar a las ventas</li>
                    <li>✗ No puedes editar productos ni precios</li>
                    <li>✗ No puedes eliminar ventas antiguas</li>
                    <li>⚠️ Si tienes dudas, consulta con el administrador</li>
                </ul>
            </div>
        </div>
    </div>

</div>

{{-- Modal de Ayuda (mantén el modal igual) --}}
<!-- ... código del modal ... -->

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

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

<script>
function mostrarAyuda() {
    document.getElementById('modalAyuda').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function cerrarAyuda() {
    document.getElementById('modalAyuda').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Cerrar modal al hacer clic fuera
document.getElementById('modalAyuda').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarAyuda();
    }
});
</script>
@endsection