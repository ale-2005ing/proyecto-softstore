@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-900 text-white min-h-screen flex flex-col items-center">

    <h1 class="text-3xl font-bold mb-6">Editar Proveedor</h1>

    {{-- Mostrar errores de validación --}}
    @if($errors->any())
        <div class="bg-red-600 text-white p-4 rounded mb-4 w-full max-w-lg">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form action="{{ route('proveedores.update', $proveedor) }}" 
      method="POST" 
      class="grid gap-4 w-full max-w-lg">

        @csrf
        @method('PUT')

        {{-- Nombre (solo letras) --}}
        <input type="text" 
               name="nombre" 
               placeholder="Nombre del proveedor"
               class="p-3 rounded bg-white text-black placeholder:text-gray-500"
               style="color: black;"
               pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
               oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')"
               value="{{ old('nombre', $proveedor->nombre) }}"
               required>

        {{-- Teléfono (solo números) --}}
        <input type="text" 
               name="telefono" 
               placeholder="Teléfono"
               class="p-3 rounded bg-white text-black placeholder:text-gray-500"
               style="color: black;"
               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
               maxlength="10"
               value="{{ old('telefono', $proveedor->telefono) }}">

        {{-- Email con validación --}}
        <input type="email" 
               name="email" 
               placeholder="Email"
               class="p-3 rounded bg-white text-black placeholder:text-gray-500"
               style="color: black;"
               value="{{ old('email', $proveedor->email) }}"
               required>

        <div class="flex gap-4">
            <button type="submit" class="bg-green-600 px-4 py-3 rounded font-bold hover:bg-green-700 flex-1">
                Actualizar
            </button>
            
            <a href="{{ route('proveedores.index') }}" 
               class="bg-gray-600 px-4 py-3 rounded font-bold hover:bg-gray-700 flex-1 text-center">
                Cancelar
            </a>
        </div>
    </form>

</div>
@endsection