<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen p-6">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">← Volver al Dashboard</a>
                    <h1 class="text-3xl font-bold text-gray-900 mt-4">Notificaciones</h1>
                </div>
                
                @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('notificaciones.marcarTodasLeidas') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Marcar todas como leídas
                    </button>
                </form>
                @endif
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="space-y-4">
                @forelse($notificaciones as $notificacion)
                <div class="bg-white rounded-lg shadow p-6 {{ $notificacion->read_at ? 'opacity-75' : 'border-l-4 border-blue-500' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ $notificacion->data['titulo'] ?? 'Notificación' }}
                            </h3>
                            <p class="text-gray-600 mt-2">
                                {{ $notificacion->data['mensaje'] ?? 'Sin mensaje' }}
                            </p>
                            <p class="text-sm text-gray-500 mt-3">
                                {{ $notificacion->created_at->diffForHumans() }}
                            </p>
                        </div>
                        
                        @if(!$notificacion->read_at)
                        <form action="{{ route('notificaciones.marcarLeida', $notificacion->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="ml-4 text-blue-600 hover:text-blue-800 text-sm">
                                Marcar como leída
                            </button>
                        </form>
                        @else
                        <span class="ml-4 text-green-600 text-sm">✓ Leída</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700">No tienes notificaciones</h3>
                    <p class="text-gray-500 mt-2">Cuando recibas notificaciones, aparecerán aquí</p>
                </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $notificaciones->links() }}
            </div>
        </div>
    </div>
</body>
</html>