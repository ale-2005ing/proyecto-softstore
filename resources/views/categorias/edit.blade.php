@extends('layouts.app')

@section('title', 'Crear Categoría')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="mb-6 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
            <a href="{{ route('categorias.index') }}" 
       class="text-blue-600 hover:text-blue-700 transition-all duration-300 inline-flex items-center gap-2 font-medium hover:gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Volver a Categorías
    </a>
        <h1 class="text-3xl font-bold text-slate-800">Crear Nueva Categoría</h1>
        <p class="text-slate-600 mt-2">Organiza mejor tus productos con categorías</p>
    </div>

    <form action="{{ route('categorias.store') }}" method="POST"
          class="bg-white p-8 rounded-xl shadow-sm border border-slate-200 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards] hover:shadow-md transition-shadow duration-300">
        @csrf

        {{-- Nombre --}}
        <div class="mb-6 opacity-0 animate-[slideIn_0.5s_ease-out_0.4s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Nombre de la Categoría <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="nombre"
                   id="nombreCategoria"
                   value="{{ old('nombre') }}"
                   required
                   maxlength="50"
                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                   title="Solo se permiten letras y espacios"
                   class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400"
                   placeholder="Ej: Bebidas, Comidas, Snacks, Postres...">
            @error('nombre')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Info adicional --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 opacity-0 animate-[fadeInUp_0.5s_ease-out_0.5s_forwards]">
            <h3 class="text-sm font-semibold text-blue-800 mb-2 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Información
            </h3>
            <p class="text-sm text-blue-700 mb-2">
                Las categorías te ayudan a organizar tu tienda de alimentos y bebidas. 
            </p>
            <p class="text-sm text-blue-700">
                <strong>Ejemplos sugeridos:</strong> Bebidas Frías, Bebidas Calientes, Comidas Rápidas, 
                Almuerzos, Snacks, Postres, Dulces, Helados, Panadería, etc.
            </p>
        </div>

        {{-- Botones --}}
        <div class="flex gap-3 pt-4 border-t border-slate-200 opacity-0 animate-[fadeInUp_0.5s_ease-out_0.6s_forwards]">
            <a href="{{ route('categorias.index') }}"
               class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg font-semibold text-center transition-all duration-300 border border-slate-300 hover:scale-[1.02] hover:shadow-sm">
                Cancelar
            </a>

            <button type="submit"
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold shadow-sm transition-all duration-300 hover:scale-[1.02] hover:shadow-lg group">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Categoría
                </span>
            </button>
        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputNombre = document.getElementById('nombreCategoria');
    
    inputNombre.addEventListener('input', function(e) {
        // Remover cualquier número o carácter especial, mantener solo letras y espacios
        this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ\s]/g, '');
    });
    
    inputNombre.addEventListener('keypress', function(e) {
        // Prevenir la entrada de números y caracteres especiales
        const char = String.fromCharCode(e.which);
        if (!/[A-Za-záéíóúÁÉÍÓÚñÑ\s]/.test(char)) {
            e.preventDefault();
        }
    });
});
</script>

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