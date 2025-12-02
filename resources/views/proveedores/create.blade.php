@extends('layouts.app')

@section('title', 'Nuevo Proveedor')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('proveedores.index') }}" 
       class="text-blue-600 hover:text-blue-700 transition-all duration-300 inline-flex items-center gap-2 font-medium hover:gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Volver a Proveedores
    </a>
    
    <div class="mb-6 mt-4 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
        <h1 class="text-3xl font-bold text-slate-800">Nuevo Proveedor</h1>
        <p class="text-slate-600 mt-2">Registra un nuevo proveedor en el sistema</p>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg flex items-center gap-3 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('proveedores.store') }}" method="POST" id="formNuevoProveedor"
          class="bg-white p-8 rounded-xl shadow-sm border border-slate-200 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.3s_forwards] hover:shadow-md transition-shadow duration-300">
        @csrf

        {{-- Nombre --}}
        <div class="mb-5 opacity-0 animate-[slideIn_0.5s_ease-out_0.5s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Nombre del Proveedor <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="nombre" 
                   id="nombre"
                   value="{{ old('nombre') }}" 
                   required 
                   maxlength="100"
                   oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
                   class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400"
                   placeholder="Ingrese el nombre del proveedor">
            @error('nombre')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Teléfono --}}
        <div class="mb-5 opacity-0 animate-[slideIn_0.5s_ease-out_0.6s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">Teléfono</label>
            <input type="text" 
                   name="telefono" 
                   id="telefono"
                   value="{{ old('telefono') }}" 
                   maxlength="20"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400"
                   placeholder="Ingrese el teléfono">
            @error('telefono')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-6 opacity-0 animate-[slideIn_0.5s_ease-out_0.7s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Email <span class="text-red-500">*</span>
            </label>
            <input type="email" 
                   name="email" 
                   id="email"
                   value="{{ old('email') }}" 
                   required
                   maxlength="255"
                   class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400"
                   placeholder="correo@ejemplo.com">
            @error('email')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Acciones --}}
        <div class="flex gap-3 pt-4 border-t border-slate-200 opacity-0 animate-[fadeInUp_0.5s_ease-out_0.8s_forwards]">
            <a href="{{ route('proveedores.index') }}"
               class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg font-semibold text-center transition-all duration-300 border border-slate-300 hover:scale-[1.02] hover:shadow-sm">
                Cancelar
            </a>

            <button type="submit"
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold shadow-sm transition-all duration-300 hover:scale-[1.02] hover:shadow-lg group">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Proveedor
                </span>
            </button>
        </div>

    </form>
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

@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    25% {
        transform: translateX(-10px);
    }
    75% {
        transform: translateX(10px);
    }
}
</style>

@endsection