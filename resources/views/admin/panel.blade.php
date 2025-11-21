<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-gray-900">Admin Panel</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <input type="text" placeholder="Buscar..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-64">
                        
                        <a href="{{ route('notificaciones.index') }}" class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1 right-1 w-5 h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                            @endif
                        </a>
                        
                        <div class="flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name=Admin+User&background=3b82f6&color=fff" alt="Avatar" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Admin User</p>
                                <p class="text-xs text-gray-500">admin@example.com</p>
                            </div>
                        </div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="ml-4 flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Welcome Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gradient-to-br from-gray-50 to-gray-100">
                <div class="max-w-7xl mx-auto px-6 py-12">
                    <!-- Welcome Header -->
                    <div class="text-center mb-12">
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">
                            Bienvenido al Panel de Administración
                        </h1>
                        <p class="text-xl text-gray-600">
                            Gestiona tu negocio de manera eficiente desde un solo lugar
                        </p>
                    </div>

                    <!-- Feature Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                        <!-- Card 1 -->
                        <a href="{{ route('clientes.index') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300 border-t-4 border-blue-500 transform hover:-translate-y-2 cursor-pointer">
                            <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Gestión de Clientes</h3>
                            <p class="text-gray-600 mb-4">Administra tu base de clientes, visualiza perfiles y mantén actualizada toda la información importante.</p>
                            <span class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                                Ir a Clientes
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </a>

                        <!-- Card 2 -->
                        <a href="{{ route('productos.index') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300 border-t-4 border-green-500 transform hover:-translate-y-2 cursor-pointer">
                            <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Control de Productos</h3>
                            <p class="text-gray-600 mb-4">Organiza tu inventario, actualiza precios y gestiona el stock de todos tus productos en tiempo real.</p>
                            <span class="inline-flex items-center text-green-600 hover:text-green-700 font-medium">
                                Ir a Productos
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </a>

                        <!-- Card 3 -->
                        <a href="{{ route('reportes.index') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300 border-t-4 border-purple-500 transform hover:-translate-y-2 cursor-pointer">
                            <div class="flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 4 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Reportes y Análisis</h3>
                            <p class="text-gray-600 mb-4">Consulta estadísticas detalladas, genera reportes y toma decisiones basadas en datos concretos.</p>
                            <span class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium">
                                Ir a Reportes
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </a>

                        <!-- Card 4 -->
                        <a href="{{ route('categorias.index') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300 border-t-4 border-yellow-500 transform hover:-translate-y-2 cursor-pointer">
                            <div class="flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Categorías</h3>
                            <p class="text-gray-600 mb-4">Organiza tus productos por categorías para facilitar la navegación y búsqueda de artículos.</p>
                            <span class="inline-flex items-center text-yellow-600 hover:text-yellow-700 font-medium">
                                Ir a Categorías
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </a>

                        <!-- Card 5 -->
                        <a href="{{ route('ventas.index') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300 border-t-4 border-red-500 transform hover:-translate-y-2 cursor-pointer">
                            <div class="flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 9h18M3 15h18M3 21h18"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Registro de Ventas</h3>
                            <p class="text-gray-600 mb-4">Consulta el historial completo de ventas, filtra por fechas y gestiona tus transacciones.</p>
                            <span class="inline-flex items-center text-red-600 hover:text-red-700 font-medium">
                                Ir a Ventas
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </a>
                           <!-- Card 5 -->
                        <a href="{{ route('entradas.index') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300 border-t-4 border-orange-500 transform hover:-translate-y-2 cursor-pointer">
                            <div class="flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 9h18M3 15h18M3 21h18"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Registro de entradas</h3>
                            <p class="text-gray-600 mb-4">Consulta el historial completo de entradas de productos,filtra por fechas y ve los Detalles.</p>
                            <span class="inline-flex items-center text-orange-600 hover:text-red-700 font-medium">
                                Ir a Ventas
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </a>

                        <!-- Card 6 -->
                         <a href="{{ route('proveedores.index') }}">
                        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300 border-t-4 border-indigo-500 transform hover:-translate-y-2">
                            <div class="flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Proveedores</h3>
                            <p class="text-gray-600 mb-4">Consulta los proveedores activos,crea o actualizalos</p>
                            <span class="inline-flex items-center text-indigo-600 font-medium">
                                Ir a Proveedores
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                            
                        </div>
                    </div>
                </a>

                    <!-- Quick Stats Banner -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-xl p-8 text-white">
                        <div class="flex flex-col md:flex-row items-center justify-between">
                            <div class="mb-4 md:mb-0">
                                <h2 class="text-2xl font-bold mb-2">¿Necesitas ayuda?</h2>
                                <p class="text-blue-100">Nuestro equipo está disponible para asistirte en cualquier momento</p>
                            </div>
                            <a href="https://wa.me/qr/XFWN5EY5MAY5M1" target="_blank" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                                Contactar Soporte
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>