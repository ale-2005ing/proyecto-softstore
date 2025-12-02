@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md border border-slate-200 max-w-2xl mx-auto">
    <a href="{{ route('clientes.index') }}" 
       class="text-blue-600 hover:text-blue-700 transition-all duration-300 inline-flex items-center gap-2 font-medium hover:gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Volver a Clientes
    </a>
    <h1 class="text-3xl font-bold text-slate-800 mt-4">Editar Cliente</h1>
    <p class="text-slate-600 mt-2">Complete la información del cliente para actualizar sus datos</p>

    {{-- Mostrar errores --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Nombre (solo letras) --}}
        <div>
            <label class="block text-sm font-medium text-slate-700">Nombre</label>
            <input type="text"
                   id="nombre"
                   name="nombre"
                   value="{{ old('nombre', $cliente->nombre) }}"
                   pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                   title="Solo se permiten letras y espacios"
                   required
                   class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300 outline-none">
            <span id="nombre-error" class="text-red-500 text-sm hidden">Solo se permiten letras y espacios</span>
        </div>

        {{-- Teléfono (solo números) --}}
        <div>
            <label class="block text-sm font-medium text-slate-700">Teléfono</label>
            <input type="text"
                   id="telefono"
                   name="telefono"
                   value="{{ old('telefono', $cliente->telefono) }}"
                   pattern="[0-9]+"
                   maxlength="10"
                   title="Solo se permiten números"
                   required
                   class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300 outline-none">
            <span id="telefono-error" class="text-red-500 text-sm hidden">Solo se permiten números (máximo 10 dígitos)</span>
        </div>

        {{-- Email (obligatorio y debe terminar en .com) --}}
        <div>
            <label class="block text-sm font-medium text-slate-700">Email</label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email', $cliente->email) }}"
                   pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.(com)$"
                   title="El correo debe terminar en .com"
                   required
                   class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300 outline-none">
            <span id="email-error" class="text-red-500 text-sm hidden">El correo debe terminar en .com</span>
        </div>

        {{-- Dirección --}}
        <div>
            <label class="block text-sm font-medium text-slate-700">Dirección</label>
            <input type="text"
                   name="direccion"
                   value="{{ old('direccion', $cliente->direccion) }}"
                   required
                   class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300 outline-none">
        </div>

        {{-- Estado --}}
        <div>
            <label class="block text-sm font-medium text-slate-700">Estado</label>
            <select name="estado"
                class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-300 outline-none">
                <option value="activo" {{ $cliente->estado === 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="moroso" {{ $cliente->estado === 'moroso' ? 'selected' : '' }}>Moroso</option>
            </select>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('clientes.index') }}"
                class="px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg transition">
                Cancelar
            </a>

            <button type="submit"
                id="submit-btn"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación para Nombre (solo letras y espacios)
    const nombreInput = document.getElementById('nombre');
    const nombreError = document.getElementById('nombre-error');
    
    nombreInput.addEventListener('input', function(e) {
        // Eliminar cualquier caracter que no sea letra o espacio
        this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
        
        if (this.value !== e.target.value) {
            nombreError.classList.remove('hidden');
        } else {
            nombreError.classList.add('hidden');
        }
    });

    // Validación para Teléfono (solo números, máximo 10)
    const telefonoInput = document.getElementById('telefono');
    const telefonoError = document.getElementById('telefono-error');
    
    telefonoInput.addEventListener('input', function(e) {
        // Eliminar cualquier caracter que no sea número
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Limitar a 10 dígitos
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
        
        if (this.value !== e.target.value || this.value.length > 10) {
            telefonoError.classList.remove('hidden');
        } else {
            telefonoError.classList.add('hidden');
        }
    });

    // Validación para Email (debe terminar en .com)
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('email-error');
    const submitBtn = document.getElementById('submit-btn');
    
    function validarEmail() {
        const regex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.com$/;
        
        if (emailInput.value && !regex.test(emailInput.value)) {
            emailError.classList.remove('hidden');
            emailInput.classList.add('border-red-500');
            return false;
        } else {
            emailError.classList.add('hidden');
            emailInput.classList.remove('border-red-500');
            return true;
        }
    }
    
    emailInput.addEventListener('blur', validarEmail);
    emailInput.addEventListener('input', validarEmail);

    // Validar antes de enviar el formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!validarEmail()) {
            e.preventDefault();
            emailInput.focus();
            alert('Por favor, ingrese un correo válido que termine en .com');
        }
    });
});
</script>
@endsection