<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Mi App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- Barra Superior -->
    <header class="bg-blue-600 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
            <h1 class="text-2xl font-bold text-white">SoftStore</h1>

            <div class="flex items-center space-x-4">
                @auth
                    <!-- Notificaciones -->
                    <a href="{{ route('notificaciones.index') }}" class="relative p-2 text-white hover:bg-blue-700 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1 right-1 w-5 h-5 bg-orange-500 rounded-full text-white text-xs flex items-center justify-center font-semibold">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>

                    <!-- Botón Inicio -->
                    @php
                        $homeRoute = auth()->user()->hasRole('admin') 
                            ? route('admin.panel') 
                            : route('empleado.panel');
                    @endphp
                    <a href="{{ $homeRoute }}" class="text-white hover:text-blue-100 transition font-medium px-3 py-2 rounded-lg hover:bg-blue-700">
                        Inicio
                    </a>

                    <!-- Avatar y Usuario -->
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff" 
                             alt="Avatar" 
                             class="w-10 h-10 rounded-full border-2 border-blue-300">
                        <div>
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-blue-100">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <!-- Cerrar Sesión -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors shadow-sm font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Cerrar Sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-blue-100 transition font-medium">Iniciar Sesión</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Contenido -->
    <main class="flex-1 w-full px-6 py-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-slate-600">
        © {{ date('Y') }} — SoftStore
    </footer>

</body>
</html>