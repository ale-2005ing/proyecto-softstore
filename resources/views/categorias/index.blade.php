@extends('layouts.app')

@section('title', 'Listado de Categorías')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="flex justify-between items-center mb-6 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Categorías</h1>
            <p class="text-slate-600 mt-1">Organiza tus productos por categorías</p>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-3 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-6 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.3s_forwards]">
        <a href="{{ route('categorias.create') }}"
           class="inline-flex bg-orange-500 hover:bg-orange-600 px-6 py-2.5 rounded-lg text-white font-semibold shadow-sm transition-all duration-300 items-center gap-2 hover:scale-105 hover:shadow-lg group">
            <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Crear Categoría
        </a>
    </div>

    <div class="space-y-3">
        @forelse ($categorias as $index => $categoria)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex justify-between items-center hover:shadow-md transition-all duration-300 opacity-0 hover:scale-[1.01]"
                 style="animation: slideIn 0.4s ease-out {{ 0.1 * ($index + 1) + 0.4 }}s forwards;">
                
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-amber-100 rounded-lg">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-semibold text-slate-800">{{ $categoria->nombre }}</span>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('categorias.edit', $categoria->id) }}">
                        <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-sm transition-all duration-300 hover:scale-110">
                            Editar
                        </button>
                    </a>

                    <form action="{{ route('categorias.destroy', $categoria->id) }}" 
                          method="POST"
                          onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?');"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold text-sm transition-all duration-300 hover:scale-110">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center opacity-0 animate-[fadeInUp_0.6s_ease-out_0.4s_forwards]">
                <div class="flex flex-col items-center justify-center text-slate-500">
                    <svg class="w-16 h-16 mb-4 text-slate-300 animate-[pulse_2s_ease-in-out_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <p class="text-lg font-medium mb-1">No hay categorías registradas</p>
                    <p class="text-sm">Comienza creando tu primera categoría</p>
                </div>
            </div>
        @endforelse
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