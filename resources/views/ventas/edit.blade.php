@extends('layouts.app')

@section('title', 'Editar Venta')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Editar Venta #{{ $venta->numero }}</h2>
                <p class="text-slate-600">Modifica los productos y cantidades de esta venta</p>
            </div>
            <a href="{{ route('ventas.show', $venta->id) }}" 
               class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg font-semibold transition-all">
                Cancelar
            </a>
        </div>

        <form action="{{ route('ventas.update', $venta->id) }}" method="POST" id="formEditarVenta">
            @csrf
            @method('PUT')

            {{-- Cliente --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Cliente</label>
                <select name="cliente_id" 
                        class="w-full p-3 rounded-lg bg-slate-50 text-slate-800 border border-slate-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 outline-none">
                    <option value="">Consumidor Final</option>
                    @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $venta->cliente_id == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }} - {{ $cliente->documento }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Productos --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <label class="block text-sm font-semibold text-slate-700">Productos</label>
                    <button type="button" 
                            onclick="agregarProducto()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Agregar Producto
                    </button>
                </div>

                <div id="productosContainer" class="space-y-3">
                    @foreach($venta->detalles as $index => $detalle)
                    <div class="producto-item bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            <div class="md:col-span-5">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Producto</label>
                                <select name="productos[{{ $index }}][producto_id]" 
                                        class="w-full p-2 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 outline-none producto-select"
                                        onchange="actualizarPrecio(this)"
                                        required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}" 
                                            data-precio="{{ $producto->precio }}"
                                            data-stock="{{ $producto->stock }}"
                                            {{ $detalle->producto_id == $producto->id ? 'selected' : '' }}>
                                        {{ $producto->nombre }} (Stock: {{ $producto->stock }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Cantidad</label>
                                <input type="number" 
                                       name="productos[{{ $index }}][cantidad]" 
                                       value="{{ $detalle->cantidad }}"
                                       min="1" 
                                       class="w-full p-2 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 outline-none cantidad-input"
                                       onchange="calcularSubtotal(this)"
                                       required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Precio</label>
                                <input type="number" 
                                       name="productos[{{ $index }}][precio]" 
                                       value="{{ $detalle->precio }}"
                                       step="0.01" 
                                       min="0" 
                                       class="w-full p-2 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 outline-none precio-input"
                                       onchange="calcularSubtotal(this)"
                                       required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Subtotal</label>
                                <input type="text" 
                                       class="w-full p-2 rounded-lg bg-slate-100 text-slate-800 border border-slate-300 font-semibold subtotal-display"
                                       value="${{ number_format($detalle->subtotal, 2) }}"
                                       readonly>
                            </div>

                            <div class="md:col-span-1 flex justify-center">
                                <button type="button" 
                                        onclick="eliminarProducto(this)" 
                                        class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Totales --}}
            <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl border border-slate-200 p-6">
                <div class="max-w-sm ml-auto space-y-2">
                    <div class="flex justify-between text-slate-700">
                        <span>Subtotal:</span>
                        <span class="font-semibold" id="subtotalTotal">${{ number_format($venta->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-700">
                        <span>IVA (19%):</span>
                        <span class="font-semibold" id="impuestoTotal">${{ number_format($venta->impuesto, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold text-slate-800 pt-2 border-t border-slate-300">
                        <span>Total:</span>
                        <span class="text-green-600" id="granTotal">${{ number_format($venta->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all hover:scale-105 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Cambios
                </button>
                <a href="{{ route('ventas.show', $venta->id) }}" 
                   class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-lg font-semibold text-center transition-all hover:scale-105">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
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
</style>

<script>
let contadorProductos = {{ count($venta->detalles) }};
const productosData = @json($productos);

function agregarProducto() {
    const container = document.getElementById('productosContainer');
    const html = `
        <div class="producto-item bg-slate-50 border border-slate-200 rounded-lg p-4 animate-[slideIn_0.3s_ease-out]">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-5">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Producto</label>
                    <select name="productos[${contadorProductos}][producto_id]" 
                            class="w-full p-2 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 outline-none producto-select"
                            onchange="actualizarPrecio(this)"
                            required>
                        <option value="">Seleccionar...</option>
                        ${productosData.map(p => `
                            <option value="${p.id}" data-precio="${p.precio}" data-stock="${p.stock}">
                                ${p.nombre} (Stock: ${p.stock})
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Cantidad</label>
                    <input type="number" name="productos[${contadorProductos}][cantidad]" value="1" min="1" 
                           class="w-full p-2 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 outline-none cantidad-input"
                           onchange="calcularSubtotal(this)" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Precio</label>
                    <input type="number" name="productos[${contadorProductos}][precio]" value="0" step="0.01" min="0"
                           class="w-full p-2 rounded-lg bg-white text-slate-800 border border-slate-300 focus:border-blue-500 outline-none precio-input"
                           onchange="calcularSubtotal(this)" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Subtotal</label>
                    <input type="text" class="w-full p-2 rounded-lg bg-slate-100 text-slate-800 border border-slate-300 font-semibold subtotal-display" value="$0.00" readonly>
                </div>
                <div class="md:col-span-1 flex justify-center">
                    <button type="button" onclick="eliminarProducto(this)" 
                            class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    contadorProductos++;
    calcularTotales();
}

function eliminarProducto(btn) {
    const items = document.querySelectorAll('.producto-item');
    if (items.length <= 1) {
        alert('Debe haber al menos un producto en la venta');
        return;
    }
    btn.closest('.producto-item').remove();
    calcularTotales();
}

function actualizarPrecio(select) {
    const option = select.options[select.selectedIndex];
    const precio = option.dataset.precio || 0;
    const item = select.closest('.producto-item');
    const precioInput = item.querySelector('.precio-input');
    precioInput.value = precio;
    calcularSubtotal(precioInput);
}

function calcularSubtotal(input) {
    const item = input.closest('.producto-item');
    const cantidad = parseFloat(item.querySelector('.cantidad-input').value) || 0;
    const precio = parseFloat(item.querySelector('.precio-input').value) || 0;
    const subtotal = cantidad * precio;
    item.querySelector('.subtotal-display').value = '$' + subtotal.toFixed(2);
    calcularTotales();
}

function calcularTotales() {
    let subtotal = 0;
    document.querySelectorAll('.producto-item').forEach(item => {
        const cantidad = parseFloat(item.querySelector('.cantidad-input').value) || 0;
        const precio = parseFloat(item.querySelector('.precio-input').value) || 0;
        subtotal += cantidad * precio;
    });
    
    const impuesto = subtotal * 0.19;
    const total = subtotal + impuesto;
    
    document.getElementById('subtotalTotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('impuestoTotal').textContent = '$' + impuesto.toFixed(2);
    document.getElementById('granTotal').textContent = '$' + total.toFixed(2);
}

// Calcular totales al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    calcularTotales();
});
</script>
@endsection