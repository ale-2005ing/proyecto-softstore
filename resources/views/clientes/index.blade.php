@extends('layouts.app')

@section('title', 'Clientes')

@section('content')

<div class="pagina-productos">

<style>
    .pagina-productos {
        background: #0f172a;
        color: #e2e8f0;
        padding: 30px;
        min-height: 100vh;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Inter, sans-serif;
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

    .acciones button {
        color: #f87171;
        border: none;
        background: none;
        cursor: pointer;
        font-weight: 500;
        transition: 0.2s;
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
    <a href="{{ route('clientes.create') }}" class="btn btn-blue">➕ Nuevo Cliente</a>
</div>

<h1>Listado de Clientes</h1>

@if (session('success'))
    <div class="bg-green-600 text-white p-3 mb-4 rounded">
        {{ session('success') }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($clientes as $cliente)
            <tr>
                <td>{{ $cliente->id }}</td>
                <td>{{ $cliente->nombre }}</td>
                <td>{{ $cliente->telefono }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->direccion }}</td>

                <td class="acciones">
                    <form action="{{ route('clientes.destroy', $cliente->id) }}" 
                          method="POST"
                          onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="6" class="no-data">No hay clientes registrados</td>
            </tr>
        @endforelse
    </tbody>

</table>

</div>
@endsection
