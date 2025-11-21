@extends('layouts.app')

@section('content')
<div class="p-8 text-white bg-gray-900 min-h-screen">

    <h1 class="text-3xl font-bold mb-6">Registrar Entrada de Productos</h1>

    <form action="{{ route('entradas.store') }}" method="POST">
        @csrf

        {{-- Selección de proveedor --}}
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Seleccione Proveedor:</label>
            <select name="proveedor_id" class="w-full p-2 rounded text-black" required>
                <option value="">Seleccione...</option>
                @foreach ($proveedores as $prov)
                    <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                @endforeach
            </select>
        </div>

        <hr class="my-6 border-gray-700">

        <h2 class="text-xl font-semibold mb-4">Productos</h2>

        <div id="productos-container">

            {{-- Primer producto --}}
            <div class="producto-item mb-6 p-4 bg-gray-800 rounded">
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <label>
                        <input type="checkbox" class="toggle-nuevo">
                        <span class="ml-2">Crear producto nuevo</span>
                    </label>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    {{-- Seleccionar existente --}}
                    <select name="productos[0][producto_id]" class="select-existente p-2 rounded text-black">
                        <option value="">Seleccione producto existente</option>
                        @foreach ($productos as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->nombre }}</option>
                        @endforeach
                    </select>

                    {{-- Crear nuevo --}}
                    <input type="text" name="productos[0][nombre]" placeholder="Nuevo nombre" class="input-nuevo p-2 rounded text-black hidden">

                    <input type="number" name="productos[0][cantidad]" placeholder="Cantidad" class="p-2 rounded text-black" required>

                    <input type="number" step="0.01" name="productos[0][precio_compra]" placeholder="Precio compra" class="p-2 rounded text-black" required>
                </div>
            </div>

        </div>

        <button type="button" onclick="agregarProducto()" class="bg-green-600 px-4 py-2 rounded mb-6">
            + Agregar Producto
        </button>

        <button class="bg-blue-600 px-6 py-2 rounded font-bold">
            Guardar Entrada
        </button>

    </form>

</div>

<script>
let contador = 1;

function agregarProducto() {
    const cont = document.getElementById('productos-container');

    cont.insertAdjacentHTML('beforeend', `
        <div class="producto-item mb-6 p-4 bg-gray-800 rounded">

            <div class="grid grid-cols-2 gap-4 mb-3">
                <label>
                    <input type="checkbox" class="toggle-nuevo">
                    <span class="ml-2">Crear producto nuevo</span>
                </label>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <select name="productos[${contador}][producto_id]" class="select-existente p-2 rounded text-black">
                    <option value="">Seleccione producto existente</option>
                    @foreach ($productos as $prod)
                        <option value="{{ $prod->id }}">{{ $prod->nombre }}</option>
                    @endforeach
                </select>

                <input type="text" name="productos[${contador}][nombre]" placeholder="Nuevo nombre" class="input-nuevo p-2 rounded text-black hidden">

                <input type="number" name="productos[${contador}][cantidad]" placeholder="Cantidad" class="p-2 rounded text-black" required>

                <input type="number" step="0.01" name="productos[${contador}][precio_compra]" placeholder="Precio compra" class="p-2 rounded text-black" required>
            </div>
        </div>
    `);

    contador++;
    activarToggles();
}

function activarToggles() {
    document.querySelectorAll('.toggle-nuevo').forEach((checkbox, index) => {
        checkbox.onchange = () => {
            let item = checkbox.closest('.producto-item');
            let selectExistente = item.querySelector('.select-existente');
            let inputNuevo = item.querySelector('.input-nuevo');

            if (checkbox.checked) {
                selectExistente.classList.add('hidden');
                inputNuevo.classList.remove('hidden');
                selectExistente.value = "";
            } else {
                inputNuevo.classList.add('hidden');
                selectExistente.classList.remove('hidden');
                inputNuevo.value = "";
            }
        };
    });
}

activarToggles();
</script>

@endsection
