@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="mb-6 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
                <a href="{{ route('clientes.index') }}" 
           class="text-blue-600 hover:text-blue-700 transition-all duration-300 inline-flex items-center gap-2 font-medium hover:gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a Clientes
        </a>
        <h1 class="text-3xl font-bold text-slate-800">Registrar Cliente</h1>
        <p class="text-slate-600 mt-2">Complete la información del nuevo cliente</p>
            

    </div>

    <form action="{{ route('clientes.store') }}" method="POST" 
          class="bg-white p-8 rounded-xl shadow-sm border border-slate-200 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards] hover:shadow-md transition-shadow duration-300"
          id="formCliente">
        @csrf

        <div class="mb-5 opacity-0 animate-[slideIn_0.5s_ease-out_0.4s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">Nombre</label>
            <input type="text" 
                   name="nombre" 
                   id="nombre"
                   value="{{ old('nombre') }}"
                   class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400" 
                   placeholder="Ingrese el nombre completo"
                   oninput="this.value = this.value.replace(/[0-9]/g, '')"
                   required>
            @error('nombre')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5 opacity-0 animate-[slideIn_0.5s_ease-out_0.5s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">Teléfono</label>
            <input type="text" 
                   name="telefono" 
                   id="telefono"
                   value="{{ old('telefono') }}"
                   class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400"
                   placeholder="Ej: +57 300 123 4567"
                   oninput="this.value = this.value.replace(/[^0-9+\s]/g, '')">
            @error('telefono')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5 opacity-0 animate-[slideIn_0.5s_ease-out_0.6s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
            <input type="email" 
                   name="email" 
                   id="email"
                   value="{{ old('email') }}"
                   class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400"
                   placeholder="correo@ejemplo.com">
            <span id="emailError" class="text-red-500 text-sm mt-1 hidden animate-[shake_0.5s_ease-in-out]">El correo debe terminar en .com</span>
            @error('email')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 opacity-0 animate-[slideIn_0.5s_ease-out_0.7s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">Dirección</label>
            <input type="text" 
                   name="direccion" 
                   id="direccion"
                   value="{{ old('direccion') }}"
                   class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400"
                   placeholder="Calle, ciudad, departamento">
            @error('direccion')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3 pt-4 border-t border-slate-200 opacity-0 animate-[fadeInUp_0.5s_ease-out_0.8s_forwards]">
            <a href="{{ route('clientes.index') }}" 
               class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg font-semibold text-center transition-all duration-300 border border-slate-300 hover:scale-[1.02] hover:shadow-sm">
                Cancelar
            </a>
            <button type="submit" 
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold shadow-sm transition-all duration-300 hover:scale-[1.02] hover:shadow-lg group">
                <span class="flex items-center justify-center gap-2">
                    Guardar Cliente
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
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

<script>
document.getElementById('formCliente').addEventListener('submit', function(e) {
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const email = emailInput.value.trim();
    
    // Validar que el email termine en .com
    if (email && !email.endsWith('.com')) {
        e.preventDefault();
        emailError.classList.remove('hidden');
        emailInput.classList.add('border-red-500');
        emailInput.focus();
        return false;
    } else {
        emailError.classList.add('hidden');
        emailInput.classList.remove('border-red-500');
    }
});

// Limpiar el error cuando el usuario escribe
document.getElementById('email').addEventListener('input', function() {
    const emailError = document.getElementById('emailError');
    if (this.value.endsWith('.com')) {
        emailError.classList.add('hidden');
        this.classList.remove('border-red-500');
    }
});
</script>

@endsection