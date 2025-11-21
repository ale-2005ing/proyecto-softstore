@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="min-h-screen bg-gray-900 p-8">
    <div class="max-w-2xl mx-auto">
        
        {{-- Encabezado --}}
        <div class="mb-6">
            <a href="{{ route('productos.index') }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                ← Volver a Productos
            </a>
            <h1 class="text-3xl font-bold text-white mt-4">Crear Nuevo Producto</h1>
        </div>

        {{-- Mensaje de Éxito --}}
        @if (session('success'))
            <div class="bg-green-900 border border-green-700 text-green-200 px-4 py-3 rounded-lg mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Mensajes de Error --}}
        @if ($errors->any())
            <div class="bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded-lg mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <div class="bg-gray-800 rounded-lg shadow-xl p-6">
            <form action="{{ route('productos.store') }}" method="POST">
                @csrf

                {{-- Nombre del Producto --}}
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-300 mb-2">
                        Nombre del Producto <span class="text-red-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nombre" 
                        id="nombre" 
                        value="{{ old('nombre') }}"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Ej: Laptop Dell Inspiron"
                        required
                        maxlength="50"
                    >
                    <p class="text-xs text-gray-400 mt-1">
                        Si el producto ya existe, solo se aumentará el stock en 1 unidad.
                    </p>
                </div>

                {{-- Precio --}}
                <div class="mb-4">
                    <label for="precio" class="block text-sm font-medium text-gray-300 mb-2">
                        Precio <span class="text-red-400">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="precio" 
                        id="precio" 
                        value="{{ old('precio') }}"
                        step="0.01" 
                        min="0"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="0.00"
                        required
                    >
                </div>

                {{-- Categoría --}}
                <div class="mb-6">
                    <label for="categoria_id" class="block text-sm font-medium text-gray-300 mb-2">
                        Categoría (Opcional)
                    </label>
                    <select 
                        name="categoria_id" 
                        id="categoria_id"
                        class="w-full px-4 py-2 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    >
                        <option value="">Sin categoría</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Información Adicional --}}
                <div class="bg-blue-900 bg-opacity-30 border border-blue-700 rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-semibold text-blue-300 mb-2">ℹ️ Información</h3>
                    <ul class="text-sm text-blue-200 space-y-1">
                        <li>• El stock inicial será de <strong>1 unidad</strong></li>
                        <li>• Stock mínimo por defecto: <strong>1</strong></li>
                        <li>• Stock máximo por defecto: <strong>9999</strong></li>
                        <li>• Si el producto ya existe, solo se aumentará el stock</li>
                    </ul>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3">
                    <a 
                        href="{{ route('productos.index') }}" 
                        class="px-6 py-2 bg-gray-700 text-gray-200 rounded-lg hover:bg-gray-600 transform hover:-translate-y-1 hover:shadow-xl transition-all duration-300"
                    >
                        Cancelar
                    </a>
                    <button 
                        type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transform hover:-translate-y-1 hover:shadow-xl transition-all duration-300"
                    >
                        Guardar Producto
                    </button>
                </div>

            </form>
        </div>

        {{-- Ayuda adicional --}}
        <div class="mt-6 bg-yellow-900 bg-opacity-30 border border-yellow-700 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-yellow-300 mb-2">💡 Consejo</h3>
            <p class="text-sm text-yellow-200">
                Si necesitas agregar múltiples unidades del mismo producto, solo créalo varias veces 
                o edita el producto después para aumentar el stock manualmente.
            </p>
        </div>

    </div>
</div>
@endsection