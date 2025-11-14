@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<style>
    body {
        background: #0f172a;
        color: #e2e8f0;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Inter, sans-serif;
        margin: 0;
        padding: 30px;
    }

    h1 {
        color: #60a5fa;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    a.btn {
        background: #334155;
        color: #f8fafc;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        transition: 0.2s;
    }

    a.btn:hover {
        background: #475569;
    }

    .btn-blue {
        background: #3b82f6;
    }

    .btn-blue:hover {
        background: #2563eb;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #1e293b;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.4);
    }

    th, td {
        padding: 12px 16px;
        text-align: left;
    }

    th {
        background: #334155;
        color: #93c5fd;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
    }

    tr:nth-child(even) {
        background: #0f172a;
    }

    tr:hover {
        background: #1e293b;
    }

    .acciones a, .acciones button {
        color: #93c5fd;
        text-decoration: none;
        margin-right: 10px;
        border: none;
        background: none;
        cursor: pointer;
        font-weight: 500;
        transition: 0.2s;
    }

    .acciones a:hover {
        color: #60a5fa;
    }

    .acciones button {
        color: #f87171;
    }

    .acciones button:hover {
        color: #ef4444;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        color: #94a3b8;
    }
</style>

<div class="top-bar">
    <a href="{{ route('dashboard') }}" class="btn">⬅ Volver al Dashboard</a>
    <a href="{{ route('productos.create') }}" class="btn btn-blue">➕ Nuevo Producto</a>
</div>

<h1>Listado de Productos</h1>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Proveedor</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($productos as $producto)
        <tr>
            <td>{{ $producto->nombre }}</td>
            <td>{{ $producto->descripcion }}</td>
            <td>{{ $producto->categoria?->nombre ?? '—' }}</td>
            <td>{{ $producto->proveedor?->nombre ?? '—' }}</td>
            <td>{{ $producto->stock }}</td>
            <td>${{ number_format($producto->precio, 2) }}</td>
            <td class="acciones">
                <a href="{{ route('productos.edit', $producto->id) }}">Editar</a>

                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline"
                      onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="no-data">No hay productos registrados</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection

