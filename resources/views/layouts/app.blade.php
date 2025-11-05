<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Mi App')</title>

    {{-- Carga Tailwind + Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen flex flex-col">

    <!-- Barra Superior -->
    <header class="bg-gray-800 border-b border-blue-600 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
            <h1 class="text-xl font-semibold text-blue-400">
                SoftStore
            </h1>

            <nav class="space-x-4">
                <a href="/" class="hover:text-blue-500 transition">Inicio</a>
            
            </nav>
        </div>
    </header>

    <!-- Contenido -->
    <main class="flex-1 max-w-4xl mx-auto w-full px-6 py-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 border-t border-gray-700 py-4 text-center text-gray-400">
        © {{ date('Y') }} — SoftStore
    </footer>

</body>
</html>
