@extends('layouts.app')

@section('title', 'Listado de Ventas')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Ventas</h1>
            <p class="text-slate-600 mt-1">Historial completo de transacciones</p>
        </div>

        <a href="{{ route('ventas.create') }}"
           class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold shadow-sm transition-all duration-300 flex items-center gap-2 hover:scale-105 hover:shadow-lg group">
            <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Crear Venta
        </a>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg flex items-center gap-3 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabla --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden opacity-0 animate-[fadeInUp_0.6s_ease-out_0.4s_forwards] hover:shadow-md transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700"># Venta</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Cliente</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Vendedor</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Fecha</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-slate-700">Total</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Estado</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($ventas as $index => $venta)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition-all duration-300 opacity-0"
                        style="animation: slideIn 0.4s ease-out {{ 0.1 * ($index + 1) }}s forwards;">
                        <td class="px-6 py-4 text-slate-800 font-medium">#{{ $venta->numero }}</td>

                        <td class="px-6 py-4 text-slate-700">
                            {{ $venta->cliente->nombre ?? 'Consumidor final' }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">{{ $venta->user->name }}</td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}
                        </td>

                        <td class="px-6 py-4 text-right font-bold text-green-600">
                            ${{ number_format($venta->total, 2) }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 transition-all duration-300 hover:scale-105 inline-block">
                                {{ ucfirst($venta->estado) }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex gap-2 justify-center">
                                {{-- Ver --}}
                                <a href="{{ route('ventas.show', $venta) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 hover:scale-110 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Ver
                                </a>

                                {{-- PDF --}}
                                <a href="{{ route('ventas.pdf', $venta) }}"
                                   class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 hover:scale-110 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    PDF
                                </a>
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-500 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
                                <svg class="w-16 h-16 mb-4 text-slate-300 animate-[pulse_2s_ease-in-out_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="text-lg font-medium mb-1">No hay ventas registradas</p>
                                <p class="text-sm">Las ventas aparecerán aquí una vez realizadas</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    <div class="mt-6 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.6s_forwards]">
        {{ $ventas->links('pagination::tailwind') }}
    </div>

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