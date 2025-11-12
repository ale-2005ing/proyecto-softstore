{{-- resources/views/empleado/panel.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Empleado</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white min-h-screen flex flex-col items-center justify-center">

    <div class="bg-gray-800 p-8 rounded-xl shadow-lg w-full max-w-md text-center">
        <h1 class="text-3xl font-bold mb-6">Bienvenido, Empleado</h1>

        <p class="mb-6 text-gray-300">
            Aquí va la información del empleado o funcionalidades del sistema.
        </p>

        {{-- Botón logout --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                class="bg-red-600 hover:bg-red-700 transition px-6 py-2 rounded-lg font-semibold">
                Cerrar sesión
            </button>
        </form>
    </div>

</body>
</html>
