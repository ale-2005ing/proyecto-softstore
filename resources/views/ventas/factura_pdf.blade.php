<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $venta->numero }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .totales {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>FACTURA ELECTRÓNICA</h2>
    </div>

    <div class="info">
        <p><strong>Número:</strong> {{ $venta->numero }}</p>
        <p><strong>Fecha:</strong> {{ $venta->fecha->format('d/m/Y H:i') }}</p>
        <p><strong>Cliente:</strong> {{ $venta->cliente->nombre ?? 'Consumidor final' }}</p>
        <p><strong>Vendedor:</strong> {{ $venta->user->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $d)
            <tr>
                <td>{{ $d->producto->nombre }}</td>
                <td>{{ $d->cantidad }}</td>
                <td>${{ number_format($d->precio, 2) }}</td>
                <td>${{ number_format($d->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totales">
        <p>Subtotal: ${{ number_format($venta->subtotal, 2) }}</p>
        <p>Impuesto: ${{ number_format($venta->impuesto, 2) }}</p>
        <p><strong>Total: ${{ number_format($venta->total, 2) }}</strong></p>
    </div>
</body>
</html>