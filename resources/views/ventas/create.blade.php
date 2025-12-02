@extends('layouts.app')

@section('title', 'Crear Venta')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Título con animación --}}
    <div class="mb-6 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
        <a href="{{ route('ventas.index') }}" 
           class="text-blue-600 hover:text-blue-700 transition-all duration-300 inline-flex items-center gap-2 font-medium hover:gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a Ventas
        </a>
        <h1 class="text-3xl font-bold text-slate-800 mt-4">Registrar Venta</h1>
        <p class="text-slate-600 mt-1">Completa los datos para generar una nueva venta</p>
    </div>

    {{-- Mensajes de error --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6">
            <p class="font-semibold mb-2">Por favor corrige los siguientes errores:</p>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Card principal --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6
                opacity-0 animate-[fadeInUp_0.6s_ease-out_0.3s_forwards]">

        <form action="{{ route('ventas.store') }}" method="POST" id="formVenta">
            @csrf

            {{-- Cliente --}}
            <div class="mb-4">
                <label class="text-sm font-semibold text-slate-700">Cliente</label>
                <select name="cliente_id"
                        class="mt-1 bg-slate-100 border border-slate-300 p-3 rounded-lg w-full
                        text-slate-800 focus:ring-2 focus:ring-orange-400 transition-all">
                    <option value="">Consumidor final</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Productos --}}
            <div class="overflow-x-auto rounded-lg border border-slate-200 mt-6">
                <table class="w-full">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="p-3 text-left text-sm font-semibold text-slate-700">Producto</th>
                            <th class="p-3 text-left text-sm font-semibold text-slate-700">Cant.</th>
                            <th class="p-3 text-left text-sm font-semibold text-slate-700">Precio</th>
                            <th class="p-3 text-left text-sm font-semibold text-slate-700">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tablaProductos"></tbody>
                </table>
            </div>

            {{-- Botón agregar fila --}}
            <button type="button" id="agregarProducto"
                class="mt-4 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg font-semibold 
                       shadow-sm transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center gap-2 group">
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Agregar Producto
            </button>

            {{-- Total --}}
            <h2 class="text-right text-2xl font-bold text-slate-800 mt-6">
                Total: $<span id="totalGeneral">0.00</span>
            </h2>

            {{-- Botón guardar --}}
            <button type="submit"
                class="mt-6 w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg text-lg font-semibold 
                       shadow-sm transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar Venta
            </button>
        </form>
    </div>
</div>

{{-- Scripts --}}
<script type="text/javascript">
let productos = @json($productos);
let index = 0;

const btnAgregar = document.getElementById('agregarProducto');
const tabla = document.getElementById('tablaProductos');

btnAgregar.addEventListener('click', function() {
    let opciones = productos.map(function(p) {
        return '<option value="' + p.id + '" data-precio="' + p.precio + '" data-stock="' + p.stock + '">' + p.nombre + ' — Stock: ' + p.stock + '</option>';
    }).join('');

    let fila = `
        <tr class="border-b border-slate-200 opacity-0 animate-[slideIn_0.4s_ease-out_forwards]">
            <td class="p-3">
                <select name="productos[${index}][id]" class="producto-select bg-slate-100 border p-2 rounded-lg w-full">
                    ${opciones}
                </select>
            </td>
            <td class="p-3">
                <input type="number" name="productos[${index}][cantidad]" class="cantidad-input bg-slate-100 border p-2 rounded-lg w-full" value="1" min="1">
            </td>
            <td class="p-3 precio">$0.00</td>
            <td class="p-3 subtotal">$0.00</td>
            <td class="p-3">
                <button type="button" class="eliminar-row bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg transition-all hover:scale-110">
                    X
                </button>
            </td>
        </tr>
    `;

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
        let cantidad = parseInt(cantidadInput.value) || 0;

        // Validar stock
        if (cantidad > stock) {
            cantidad = stock;
            cantidadInput.value = stock;
        }

        if (cantidad < 1) {
            cantidad = 1;
            cantidadInput.value = 1;
        }

        let subtotal = precio * cantidad;
        row.querySelector('.precio').textContent = '$' + precio.toFixed(2);
        row.querySelector('.subtotal').textContent = '$' + subtotal.toFixed(2);

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

// Validar antes de enviar
document.getElementById('formVenta').addEventListener('submit', function(e) {
    let filas = document.querySelectorAll('#tablaProductos tr');
    if (filas.length === 0) {
        e.preventDefault();
        alert('Debe agregar al menos un producto a la venta');
        return false;
    }
});
</script>

{{-- Animaciones --}}
<style>
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes slideIn {
    from { opacity: 0; transform: translateX(-20px); }
    to   { opacity: 1; transform: translateX(0); }
}
</style>

@endsection