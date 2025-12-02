@extends('layouts.app')

@section('title', 'Productos')

@section('content')

<div class="flex justify-between items-center mb-6 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
   
        <h1 class="text-3xl font-bold text-slate-800">Productos</h1>
        
       <a href="{{ route('productos.create') }}"
       class="inline-flex bg-orange-500 hover:bg-orange-600 px-6 py-2.5 rounded-lg text-white font-semibold shadow-sm transition-all duration-300 items-center gap-2 hover:scale-105 hover:shadow-lg group">
        <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo Producto
    </a>
</div>

<div class="mb-6 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
 
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

{{-- Tabla de productos --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden opacity-0 animate-[fadeInUp_0.6s_ease-out_0.4s_forwards] hover:shadow-md transition-shadow duration-300">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-100 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Nombre</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Descripción</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Categoría</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Proveedor</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Stock</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Precio</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($productos as $index => $producto)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-all duration-300 opacity-0 hover:scale-[1.01] hover:shadow-sm"
                    style="animation: slideIn 0.4s ease-out {{ 0.1 * ($index + 1) }}s forwards;">
                    <td class="px-6 py-4 text-slate-800 font-medium">{{ $producto->nombre }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $producto->descripcion }}</td>
                    <td class="px-6 py-4">
                        @if($producto->categoria)
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold transition-all duration-300 hover:bg-blue-200 hover:scale-105 inline-block">
                                {{ $producto->categoria->nombre }}
                            </span>
                        @else
                            <span class="text-slate-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $producto->proveedor?->nombre ?? '—' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold transition-all duration-300 hover:scale-105 inline-block
                            @if($producto->stock <= ($producto->stock_min ?? 0))
                                bg-red-100 text-red-700 animate-pulse
                            @elseif($producto->stock >= ($producto->stock_max ?? 100))
                                bg-green-100 text-green-700
                            @else
                                bg-amber-100 text-amber-700
                            @endif">
                            {{ $producto->stock }} unidades
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-800 font-semibold">
                        ${{ number_format($producto->precio, 2) }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('productos.edit', $producto->id) }}" 
                               class="text-blue-600 hover:text-blue-700 font-semibold text-sm transition-all duration-300 hover:scale-110 inline-block">
                                Editar
                            </a>

                            <form action="{{ route('productos.destroy', $producto->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-700 font-semibold text-sm transition-all duration-300 hover:scale-110">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-slate-500 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
                            <svg class="w-16 h-16 mb-4 text-slate-300 animate-[pulse_2s_ease-in-out_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="text-lg font-medium mb-1">No hay productos registrados</p>
                            <p class="text-sm">Comienza agregando tu primer producto al inventario</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection