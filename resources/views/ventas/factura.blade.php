@extends('layouts.app')

@section('title', 'Factura de Venta')

@section('content')
<div class="bg-gray-900 min-h-screen p-8 text-white">
    <h2 class="text-center text-2xl font-bold mb-4">FACTURA ELECTRÓNICA</h2>

    <p><strong>Número:</strong> {{ $venta->numero }}</p>
    <p><strong>Fecha:</strong> {{ $venta->fecha->format('d/m/Y H:i') }}</p>
    <p><strong>Cliente:</strong> {{ $venta->cliente->nombre ?? 'Consumidor final' }}</p>
    <p><strong>Vendedor:</strong> {{ $venta->user->name }}</p>

    <table class="w-full mt-4 text-white border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-700 text-gray-200">
                <th class="p-2 border">Producto</th>
                <th class="p-2 border">Cantidad</th>
                <th class="p-2 border">Precio</th>
                <th class="p-2 border">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $d)
            <tr class="border-b border-gray-700">
                <td class="p-2 border">{{ $d->producto->nombre }}</td>
                <td class="p-2 border">{{ $d->cantidad }}</td>
                <td class="p-2 border">${{ number_format($d->precio, 2) }}</td>
                <td class="p-2 border">${{ number_format($d->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="text-right mt-4">
        Subtotal: ${{ number_format($venta->subtotal, 2) }}<br>
        Impuesto: ${{ number_format($venta->impuesto, 2) }}<br>
        <strong>Total: ${{ number_format($venta->total, 2) }}</strong>
    </h3>

    <div class="mt-6 flex gap-4">
        <a href="{{ route('ventas.create') }}" 
           class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600">
            Nueva Venta
        </a>
        
        <a href="{{ route('ventas.pdf', $venta->id) }}" 
           target="_blank"
           class="bg-red-500 px-4 py-2 rounded hover:bg-red-600">
            📄 Descargar PDF
        </a>
        
        <button onclick="abrirModalWhatsApp()" 
                class="bg-green-500 px-4 py-2 rounded hover:bg-green-600">
            📱 Enviar WhatsApp
        </button>
    </div>
</div>

{{-- Modal para WhatsApp --}}
<div id="modalWhatsApp" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 p-6 rounded-lg max-w-md w-full mx-4">
        <h3 class="text-xl font-bold mb-4 text-white">Enviar Factura por WhatsApp</h3>
        
        @if($venta->cliente && $venta->cliente->telefono)
            <p class="mb-4 text-gray-300">
                Cliente: <strong>{{ $venta->cliente->nombre }}</strong><br>
                Teléfono registrado: <strong>{{ $venta->cliente->telefono }}</strong>
            </p>
            
            <div class="flex gap-2 mb-4">
                <button onclick="enviarWhatsApp('{{ $venta->cliente->telefono }}')" 
                        class="bg-green-500 px-4 py-2 rounded hover:bg-green-600 flex-1">
                    Enviar al cliente
                </button>
            </div>
            
            <p class="text-center text-gray-400 mb-2">O enviar a otro número:</p>
        @endif
        
        <input type="text" 
               id="telefonoPersonalizado" 
               placeholder="Ej: 3001234567"
               class="w-full p-3 rounded bg-gray-700 text-white mb-4"
               style="color: white;"
               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
               maxlength="10">
        
        <div class="flex gap-2">
            <button onclick="enviarWhatsAppPersonalizado()" 
                    class="bg-green-500 px-4 py-2 rounded hover:bg-green-600 flex-1">
                Enviar
            </button>
            <button onclick="cerrarModalWhatsApp()" 
                    class="bg-gray-600 px-4 py-2 rounded hover:bg-gray-700 flex-1">
                Cancelar
            </button>
        </div>
    </div>
</div>

<script>
function abrirModalWhatsApp() {
    document.getElementById('modalWhatsApp').classList.remove('hidden');
}

function cerrarModalWhatsApp() {
    document.getElementById('modalWhatsApp').classList.add('hidden');
    document.getElementById('telefonoPersonalizado').value = '';
}

function enviarWhatsApp(telefono) {
    const urlPdf = "{{ route('ventas.ver-pdf', $venta->id) }}";
    const mensaje = encodeURIComponent(
        `¡Hola! 👋\n\n` +
        `Te envío la factura #{{ $venta->numero }}\n\n` +
        `📋 Detalles:\n` +
        `• Cliente: {{ $venta->cliente->nombre ?? 'Consumidor final' }}\n` +
        `• Fecha: {{ $venta->fecha->format('d/m/Y H:i') }}\n` +
        `• Total: ${{ number_format($venta->total, 2) }}\n\n` +
        `📄 Puedes ver y descargar tu factura aquí:\n${urlPdf}\n\n` +
        `¡Gracias por tu compra! 😊`
    );
    
    window.open(`https://wa.me/57${telefono}?text=${mensaje}`, '_blank');
    cerrarModalWhatsApp();
}

function enviarWhatsAppPersonalizado() {
    const telefono = document.getElementById('telefonoPersonalizado').value;
    
    if (telefono.length !== 10) {
        alert('Por favor ingresa un número válido de 10 dígitos');
        return;
    }
    
    enviarWhatsApp(telefono);
}
</script>
@endsection