@extends('layouts.app')

@section('title', 'Crear Venta')

@section('content')
<div class="bg-gray-900 min-h-screen p-8 text-white">

    <h1 class="text-2xl font-bold mb-6">Registrar Venta</h1>

    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf

        {{-- Cliente --}}
        <div class="mb-4">
            <label>Cliente:</label>
            <select name="cliente_id" class="bg-gray-700 p-2 rounded w-full">
                <option value="">Consumidor final</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tabla productos --}}
        <table class="w-full text-white border">
            <thead>
                <tr>
                    <th class="p-2">Producto</th>
                    <th class="p-2">Cant.</th>
                    <th class="p-2">Precio</th>
                    <th class="p-2">Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tablaProductos"></tbody>
        </table>

        <button type="button" id="agregarProducto" class="mt-4 bg-blue-500 px-4 py-2 rounded">
            + Agregar Producto
        </button>

        <h2 class="text-right text-xl mt-4">
            Total: $<span id="totalGeneral">0.00</span>
        </h2>

        <button type="submit" class="mt-6 bg-green-500 px-6 py-2 rounded w-full">
            Guardar Venta
        </button>
    </form>
</div>

<script type="text/javascript">
let productos = @json($productos);
let index = 0;

const btnAgregar = document.getElementById('agregarProducto');
const tabla = document.getElementById('tablaProductos');

btnAgregar.addEventListener('click', function() {
    let opciones = productos.map(function(p) {
        return '<option value="' + p.id + '" data-precio="' + p.precio + '" data-stock="' + p.stock + '">' + p.nombre + ' — Stock: ' + p.stock + '</option>';
    }).join('');

    let fila = '<tr>' +
        '<td class="p-2"><select name="items[' + index + '][producto_id]" class="producto-select w-full bg-gray-700 p-2 rounded">' + opciones + '</select></td>' +
        '<td class="p-2"><input type="number" name="items[' + index + '][cantidad]" class="cantidad-input w-full bg-gray-700 p-2 rounded" value="1" min="1"></td>' +
        '<td class="p-2 precio"></td>' +
        '<td class="p-2 subtotal"></td>' +
        '<td><input type="hidden" name="items[' + index + '][precio]" class="precio-hidden"></td>' +
        '<td class="p-2"><button type="button" class="eliminar-row bg-red-500 px-3 py-1 rounded">X</button></td>' +
        '</tr>';

    tabla.insertAdjacentHTML('beforeend', fila);
    index++;
    actualizar();
});

function actualizar() {
    let total = 0;
    document.querySelectorAll('#tablaProductos tr').forEach(function(row) {
        let select = row.querySelector('.producto-select');
        if (!select) return;

        let precio = parseFloat(select.options[select.selectedIndex].dataset.precio);
        let stock = parseInt(select.options[select.selectedIndex].dataset.stock);

        let cantidadInput = row.querySelector('.cantidad-input');
        let cantidad = parseInt(cantidadInput.value);

        // Validar stock
        if(cantidad > stock) cantidad = stock;
        cantidadInput.value = cantidad;

        let subtotal = precio * cantidad;
        row.querySelector('.precio').textContent = precio.toFixed(2);
        row.querySelector('.subtotal').textContent = subtotal.toFixed(2);
        row.querySelector('.precio-hidden').value = precio;

        total += subtotal;
    });

    document.getElementById('totalGeneral').textContent = total.toFixed(2);
}

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('eliminar-row')) {
        e.target.closest('tr').remove();
        actualizar();
    }
});

document.addEventListener('input', actualizar);
document.addEventListener('change', actualizar);
</script>
@endsection
