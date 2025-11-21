@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-900 text-white min-h-screen">

    <h1 class="text-3xl font-bold mb-6">Detalles de Entrada #{{ $entrada->id }}</h1>

    <p><strong>Proveedor:</strong> {{ $entrada->proveedor->nombre }}</p>
    <p><strong>Fecha:</strong> {{ $entrada->created_at->format('d/m/Y') }}</p>

    <h2 class="text-2xl font-bold mt-6 mb-3">Productos</h2>

    <table class="w-full bg-gray-800 rounded">
        <thead>
            <tr class="border-b border-gray-700">
                <th class="p-3">Producto</th>
                <th class="p-3">Cantidad</th>
                <th class="p-3">Precio Compra</th>
                <th class="p-3">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entrada->detalles as $detalle)
                <tr class="border-b border-gray-700">
                    <td class="p-3">{{ $detalle->producto->nombre }}</td>
                    <td class="p-3">{{ $detalle->cantidad }}</td>
                    <td class="p-3">{{ $detalle->precio_compra }}</td>
                    <td class="p-3">{{ $detalle->subtotal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
