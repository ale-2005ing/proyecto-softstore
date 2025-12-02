@extends('layouts.app')

@section('title', 'Factura de Venta')

@section('content')
<div class="max-w-4xl mx-auto">
    
    {{-- Header de la factura --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 mb-6 opacity-0 animate-[fadeInDown_0.6s_ease-out_forwards]">
        <div class="text-center mb-6">
            <h2 class="text-4xl font-bold text-slate-800 mb-2">FACTURA DE VENTA </h2>
            <p class="text-slate-600">Comprobante de transacción</p>
        </div>
        
        <div class="flex justify-center gap-2 mb-4">
            <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                ✓ Venta Completada
            </span>
        </div>
    </div>

    {{-- Información general --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.2s_forwards]">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Número de Factura</p>
                    <p class="text-2xl font-bold text-slate-800">#{{ $venta->numero }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Cliente</p>
                    <p class="text-lg font-semibold text-slate-800">{{ $venta->cliente->nombre ?? 'Consumidor Final' }}</p>
                    @if($venta->cliente && $venta->cliente->telefono)
                        <p class="text-sm text-slate-600">Tel: {{ $venta->cliente->telefono }}</p>
                    @endif
                </div>
            </div>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Fecha</p>
                    <p class="text-lg font-semibold text-slate-800">{{ $venta->fecha->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Vendedor</p>
                    <p class="text-lg font-semibold text-slate-800">{{ $venta->user->name }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de productos --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.4s_forwards]">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Producto</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Cantidad</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-slate-700">Precio Unit.</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-slate-700">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venta->detalles as $index => $detalle)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition-all duration-300 opacity-0"
                        style="animation: slideIn 0.4s ease-out {{ 0.1 * ($index + 1) + 0.6 }}s forwards;">
                        <td class="px-6 py-4">
                            <p class="text-slate-800 font-medium">{{ $detalle->producto->nombre }}</p>
                            @if($detalle->producto->descripcion)
                                <p class="text-sm text-slate-500">{{ $detalle->producto->descripcion }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                                {{ $detalle->cantidad }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-slate-700 font-medium">${{ number_format($detalle->precio, 2) }}</td>
                        <td class="px-6 py-4 text-right text-slate-800 font-bold">${{ number_format($detalle->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Totales --}}
    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl shadow-sm border border-slate-200 p-6 mb-6 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.6s_forwards]">
        <div class="max-w-sm ml-auto space-y-3">
            <div class="flex justify-between text-slate-700">
                <span class="font-medium">Subtotal:</span>
                <span class="font-semibold">${{ number_format($venta->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-slate-700">
                <span class="font-medium">Impuesto (19%):</span>
                <span class="font-semibold">${{ number_format($venta->impuesto, 2) }}</span>
            </div>
            <div class="h-px bg-slate-300"></div>
            <div class="flex justify-between text-2xl font-bold text-slate-800 pt-2">
                <span>Total:</span>
                <span class="text-green-600">${{ number_format($venta->total, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Botones de acción --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-6 opacity-0 animate-[fadeInUp_0.6s_ease-out_0.8s_forwards]">
        
        {{-- Nueva Venta --}}
        <a href="{{ route('ventas.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Venta
        </a>

        {{-- Ver Lista --}}
        <a href="{{ route('ventas.index') }}" 
           class="bg-slate-600 hover:bg-slate-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            Ver Lista
        </a>

        {{-- Editar Venta --}}
        <a href="{{ route('ventas.edit', $venta->id) }}" 
           class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Editar
        </a>
        
        {{-- Descargar PDF --}}
        <a href="{{ route('ventas.pdf', $venta->id) }}" 
           target="_blank"
           class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Descargar PDF
        </a>
        
        {{-- WhatsApp --}}
        <button onclick="abrirModalWhatsApp()" 
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
            WhatsApp
        </button>

        {{-- Eliminar Venta --}}
        <button onclick="abrirModalEliminar()" 
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Eliminar
        </button>
    </div>

    {{-- Nota adicional --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 opacity-0 animate-[fadeInUp_0.6s_ease-out_1s_forwards]">
        <p class="text-sm text-blue-800 text-center">
            <strong>Nota:</strong> Conserve esta factura como comprobante de su compra. Gracias por su preferencia.
        </p>
    </div>

</div>

{{-- Modal para WhatsApp --}}
<div id="modalWhatsApp" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 animate-[fadeIn_0.3s_ease-out]">
    <div class="bg-white p-8 rounded-xl max-w-md w-full mx-4 shadow-2xl animate-[scaleIn_0.3s_ease-out]">
        <h3 class="text-2xl font-bold mb-6 text-slate-800 flex items-center gap-2">
            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
            Enviar por WhatsApp
        </h3>
        
        @if($venta->cliente && $venta->cliente->telefono)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-blue-800 mb-2">
                    <strong>Cliente:</strong> {{ $venta->cliente->nombre }}
                </p>
                <p class="text-sm text-blue-800">
                    <strong>Teléfono:</strong> {{ $venta->cliente->telefono }}
                </p>
            </div>
            
            <button onclick="enviarWhatsApp('{{ $venta->cliente->telefono }}')" 
                    class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold mb-4 transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Enviar al cliente
            </button>
            
            <p class="text-center text-slate-500 mb-3 text-sm">O enviar a otro número:</p>
        @endif
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-2">Número de WhatsApp</label>
            <input type="text" 
                   id="telefonoPersonalizado" 
                   placeholder="Ej: 3001234567"
                   class="w-full p-3 rounded-lg bg-slate-50 text-slate-800 border border-slate-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 outline-none"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   maxlength="10">
            <p class="text-xs text-slate-500 mt-1">Ingresa el número sin espacios ni guiones</p>
        </div>
        
        <div class="flex gap-3">
            <button onclick="enviarWhatsAppPersonalizado()" 
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 hover:scale-105">
                Enviar
            </button>
            <button onclick="cerrarModalWhatsApp()" 
                    class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-lg font-semibold transition-all duration-300 hover:scale-105">
                Cancelar
            </button>
        </div>
    </div>
</div>

{{-- Modal para Confirmar Eliminación --}}
<div id="modalEliminar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 animate-[fadeIn_0.3s_ease-out]">
    <div class="bg-white p-8 rounded-xl max-w-md w-full mx-4 shadow-2xl animate-[scaleIn_0.3s_ease-out]">
        <div class="flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mx-auto mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        
        <h3 class="text-2xl font-bold mb-4 text-slate-800 text-center">¿Eliminar esta venta?</h3>
        
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-amber-800 mb-2">
                <strong>⚠️ Advertencia:</strong>
            </p>
            <ul class="text-sm text-amber-700 space-y-1">
                <li>• Esta acción no se puede deshacer</li>
                <li>• Se restaurará el stock de todos los productos</li>
                <li>• La factura #{{ $venta->numero }} será eliminada</li>
            </ul>
        </div>
        
        <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="flex gap-3">
                <button type="button" 
                        onclick="cerrarModalEliminar()"
                        class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-lg font-semibold transition-all duration-300 hover:scale-105">
                    Cancelar
                </button>
                <button type="submit"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Sí, Eliminar
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

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

<script>
function abrirModalWhatsApp() {
    document.getElementById('modalWhatsApp').classList.remove('hidden');
}

function cerrarModalWhatsApp() {
    document.getElementById('modalWhatsApp').classList.add('hidden');
    document.getElementById('telefonoPersonalizado').value = '';
}

function abrirModalEliminar() {
    document.getElementById('modalEliminar').classList.remove('hidden');
}

function cerrarModalEliminar() {
    document.getElementById('modalEliminar').classList.add('hidden');
}

function enviarWhatsApp(telefono) {
    const urlPdf = "{{ route('ventas.ver-pdf', $venta->id) }}";
    const mensaje = encodeURIComponent(
        `¡Hola! 👋\n\n` +
        `Te envío la factura #{{ $venta->numero }}\n\n` +
        `📋 Detalles:\n` +
        `• Cliente: {{ $venta->cliente->nombre ?? 'Consumidor Final' }}\n` +
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

// Cerrar modales al hacer clic fuera
document.getElementById('modalWhatsApp').addEventListener('click', function(e) {
    if (e.target === this) cerrarModalWhatsApp();
});

document.getElementById('modalEliminar').addEventListener('click', function(e) {
    if (e.target === this) cerrarModalEliminar();
});
</script>
@endsection