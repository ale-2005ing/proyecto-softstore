@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('productos.index') }}" 
       class="text-blue-600 hover:text-blue-700 transition-all duration-300 inline-flex items-center gap-2 font-medium hover:gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Volver a Productos
    </a>
    
    <div class="mb-6 mt-4 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
        <h1 class="text-3xl font-bold text-slate-800">Editar Producto</h1>
        <p class="text-slate-600 mt-2">Actualiza la información del producto</p>
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

    <form action="{{ route('productos.update', $producto->id) }}" method="POST" id="formEditarProducto"
          class="bg-white p-8 rounded-xl shadow-sm border border-slate-200 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.3s_forwards] hover:shadow-md transition-shadow duration-300">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-5 opacity-0 animate-[slideIn_0.5s_ease-out_0.5s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Nombre del Producto <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="nombre" 
                   id="nombre"
                   value="{{ old('nombre', $producto->nombre) }}" 
                   required 
                   maxlength="50"
                   onkeypress="return soloLetras(event)"
                   class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400"
                   placeholder="Ingrese el nombre del producto">
            @error('nombre')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-5 opacity-0 animate-[slideIn_0.5s_ease-out_0.6s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">Descripción</label>
            <textarea name="descripcion" 
                      id="descripcion"
                      rows="3" 
                      maxlength="150"
                      oninput="document.getElementById('charCount').textContent = this.value.length"
                      class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400 resize-none"
                      placeholder="Describa las características del producto">{{ old('descripcion', $producto->descripcion) }}</textarea>
            <div class="flex justify-between items-center mt-1">
                <p class="text-xs text-slate-500">Descripción del producto</p>
                <p class="text-xs text-slate-500">
                    <span id="charCount">{{ strlen($producto->descripcion ?? '') }}</span>/150 caracteres
                </p>
            </div>
            @error('descripcion')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Precio --}}
        <div class="mb-5 opacity-0 animate-[slideIn_0.5s_ease-out_0.7s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Precio <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-semibold">$</span>
                <input type="text" 
                       name="precio" 
                       value="{{ old('precio', $producto->precio) }}" 
                       required
                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                       class="w-full pl-8 pr-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400"
                       placeholder="0.00">
            </div>
            @error('precio')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Categoría --}}
        <div class="mb-5 opacity-0 animate-[slideIn_0.5s_ease-out_0.8s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">Categoría</label>
            <select name="categoria_id"
                    class="w-full px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400">
                <option value="">Sin categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Proveedor --}}
        <div class="mb-6 opacity-0 animate-[slideIn_0.5s_ease-out_0.85s_forwards]">
            <label class="block text-sm font-medium text-slate-700 mb-2">Proveedor</label>
            <div class="flex gap-3">
                <select name="proveedor_id" id="proveedor_id"
                        class="flex-1 px-4 py-2.5 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none transition-all duration-300 hover:border-slate-400">
                    <option value="">Sin proveedor</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}"
                            {{ $producto->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
                <button 
                    type="button"
                    onclick="mostrarModalProveedor()"
                    class="px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold transition-all duration-300 hover:scale-105 flex items-center gap-2 whitespace-nowrap"
                    title="Registrar nuevo proveedor"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo
                </button>
            </div>
            @error('proveedor_id')
                <p class="text-red-500 text-sm mt-1 animate-[shake_0.5s_ease-in-out]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Acciones --}}
        <div class="flex gap-3 pt-4 border-t border-slate-200 opacity-0 animate-[fadeInUp_0.5s_ease-out_0.9s_forwards]">
            <a href="{{ route('productos.index') }}"
               class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-lg font-semibold text-center transition-all duration-300 border border-slate-300 hover:scale-[1.02] hover:shadow-sm">
                Cancelar
            </a>

            <button type="submit"
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold shadow-sm transition-all duration-300 hover:scale-[1.02] hover:shadow-lg group">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Actualizar Producto
                </span>
            </button>
        </div>

    </form>
</div>

{{-- Modal para Nuevo Proveedor --}}
<div id="modalProveedor" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto animate-[fadeInUp_0.3s_ease-out]">
        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4 flex items-center justify-between rounded-t-xl">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Registrar Nuevo Proveedor
            </h2>
            <button 
                type="button" 
                onclick="cerrarModalProveedor()" 
                class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-all duration-300"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="formNuevoProveedor" class="p-6 space-y-4">
            {{-- Nombre del Proveedor --}}
            <div>
                <label for="nuevo_proveedor_nombre" class="block text-sm font-medium text-slate-700 mb-2">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="nuevo_proveedor_nombre" 
                    class="w-full px-4 py-2.5 bg-white border border-slate-300 text-slate-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-500 transition-all duration-300"
                    placeholder="Nombre del proveedor"
                    onkeypress="return soloLetras(event)"
                    required
                    maxlength="100"
                >
            </div>

            {{-- Teléfono --}}
            <div>
                <label for="nuevo_proveedor_telefono" class="block text-sm font-medium text-slate-700 mb-2">
                    Teléfono
                </label>
                <input 
                    type="text" 
                    id="nuevo_proveedor_telefono" 
                    class="w-full px-4 py-2.5 bg-white border border-slate-300 text-slate-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-500 transition-all duration-300"
                    placeholder="Ej: +57 300 123 4567"
                    oninput="this.value = this.value.replace(/[^0-9+\s-]/g, '')"
                    maxlength="20"
                >
            </div>

            {{-- Email --}}
            <div>
                <label for="nuevo_proveedor_email" class="block text-sm font-medium text-slate-700 mb-2">
                    Email
                </label>
                <input 
                    type="email" 
                    id="nuevo_proveedor_email" 
                    class="w-full px-4 py-2.5 bg-white border border-slate-300 text-slate-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-500 transition-all duration-300"
                    placeholder="proveedor@ejemplo.com"
                    maxlength="100"
                >
            </div>

            {{-- Botones --}}
            <div class="flex gap-3 pt-4">
                <button 
                    type="button" 
                    onclick="cerrarModalProveedor()"
                    class="flex-1 px-6 py-2.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 font-semibold transition-all duration-300"
                >
                    Cancelar
                </button>
                <button 
                    type="submit"
                    class="flex-1 px-6 py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 font-semibold transition-all duration-300 flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar
                </button>
            </div>
        </form>
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
// Validación: Solo letras, espacios y acentos
function soloLetras(event) {
    const char = String.fromCharCode(event.which);
    if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]$/.test(char)) {
        event.preventDefault();
        return false;
    }
    return true;
}

// Inicializar contador de caracteres al cargar
document.addEventListener('DOMContentLoaded', function() {
    const descripcion = document.getElementById('descripcion');
    if (descripcion.value) {
        document.getElementById('charCount').textContent = descripcion.value.length;
    }
});

// Modal de Proveedor
function mostrarModalProveedor() {
    document.getElementById('modalProveedor').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function cerrarModalProveedor() {
    document.getElementById('modalProveedor').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('formNuevoProveedor').reset();
}

// Cerrar modal al hacer clic fuera de él
document.getElementById('modalProveedor').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalProveedor();
    }
});

// Manejar envío del formulario de nuevo proveedor
document.getElementById('formNuevoProveedor').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const nombre = document.getElementById('nuevo_proveedor_nombre').value.trim();
    const telefono = document.getElementById('nuevo_proveedor_telefono').value.trim();
    const email = document.getElementById('nuevo_proveedor_email').value.trim();
    
    if (!nombre) {
        alert('El nombre del proveedor es obligatorio');
        return;
    }
    
    // Obtener el token CSRF
    const token = document.querySelector('input[name="_token"]').value;
    
    // Enviar datos al servidor
    fetch('{{ route("proveedores.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            nombre: nombre,
            telefono: telefono,
            email: email
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Agregar el nuevo proveedor al select
            const select = document.getElementById('proveedor_id');
            const option = new Option(data.proveedor.nombre, data.proveedor.id, true, true);
            select.add(option);
            
            // Cerrar modal y mostrar mensaje
            cerrarModalProveedor();
            
            // Mostrar notificación de éxito
            mostrarNotificacion('✅ Proveedor registrado exitosamente', 'success');
        } else {
            alert('Error al registrar el proveedor: ' + (data.message || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al conectar con el servidor');
    });
});

// Función para mostrar notificaciones
function mostrarNotificacion(mensaje, tipo = 'success') {
    const notificacion = document.createElement('div');
    notificacion.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-[fadeInDown_0.3s_ease-out] ${
        tipo === 'success' ? 'bg-green-100 border border-green-300 text-green-700' : 'bg-red-100 border border-red-300 text-red-700'
    }`;
    
    notificacion.innerHTML = `
        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span>${mensaje}</span>
    `;
    
    document.body.appendChild(notificacion);
    
    setTimeout(() => {
        notificacion.style.animation = 'fadeInUp 0.3s ease-out reverse';
        setTimeout(() => notificacion.remove(), 300);
    }, 3000);
}
</script>

@endsection