@extends('layouts.app')

@section('title', 'Listado de Ventas')

@section('content')
<div class="min-h-screen bg-gray-900 px-6 py-10">
    <div class="max-w-6xl mx-auto bg-gray-800 rounded-2xl shadow-lg p-8">

        <h1 class="text-3xl font-bold text-white mb-6 text-center">Listado de Ventas</h1>

        {{-- Mensajes --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-600 text-white rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Botón crear venta --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route('ventas.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                Crear Venta
            </a>
        </div>

        {{-- Tabla --}}
        <div class="overflow-x-auto rounded-lg border border-gray-700">
            <table class="min-w-full bg-gray-800 text-gray-300">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left"># Venta</th>
                        <th class="px-4 py-3 text-left">Cliente</th>
                        <th class="px-4 py-3 text-left">Vendedor</th>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($ventas as $venta)
                    <tr class="border-b border-gray-700">
                        <td class="px-4 py-3">{{ $venta->numero }}</td>

                        <td class="px-4 py-3">
                            {{ $venta->cliente->nombre ?? 'Consumidor final' }}
                        </td>

                        <td class="px-4 py-3">{{ $venta->user->name }}</td>

                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}
                        </td>

                        <td class="px-4 py-3 text-right font-semibold text-green-400">
                            ${{ number_format($venta->total, 2) }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 text-sm rounded bg-blue-600 text-white">
                                {{ ucfirst($venta->estado) }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center flex gap-2 justify-center">

                            {{-- Ver --}}
                            <a href="{{ route('ventas.show', $venta) }}"
                               class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-1 rounded">
                                Ver
                            </a>

                            {{-- PDF --}}
                            <a href="{{ route('ventas.pdf', $venta) }}"
                               class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                PDF
                            </a>

                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-400">
                            No hay ventas registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-6">
            {{ $ventas->links('pagination::tailwind') }}
        </div>

    </div>
</div>
@endsection
