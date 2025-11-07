<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Crear Categoría</title>

<style>
    body {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Inter, sans-serif;
        background: #111827; /* Fondo oscuro */
        margin: 0;
        padding: 40px;
        color: white;
    }

    /* Botón regresar */
    .btn-back {
        display: inline-block;
        background: #374151; /* Gris oscuro */
        color: #e5e7eb;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        transition: 0.2s;
        margin-bottom: 25px;
        font-weight: 500;
    }

    .btn-back:hover {
        background: #4b5563;
    }

    /* Tarjeta */
    .container {
        max-width: 550px;
        margin: auto;
        background: #1f2937; /* Caja oscura */
        padding: 35px;
        border-radius: 18px;
        box-shadow: 0px 4px 14px rgba(0,0,0,0.5);
    }

    h1 {
        font-size: 28px;
        color: #60a5fa; /* Azul claro */
        font-weight: 700;
        margin-bottom: 25px;
    }

    label {
        display: block;
        color: #e5e7eb;
        font-size: 15px;
        margin-bottom: 6px;
        font-weight: 600;
    }

    input[type="text"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #374151;
        border-radius: 10px;
        font-size: 15px;
        margin-bottom: 22px;
        background: #111827;
        color: white;
        transition: 0.2s;
    }

    input[type="text"]:focus {
        border-color: #2563eb;
        outline: none;
        background: #1f2937;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.3);
    }

    /* Botón guardar */
    .btn-primary {
        width: 100%;
        background: #2563eb;
        border: none;
        padding: 14px;
        border-radius: 12px;
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

</style>
</head>

<body>

    <!-- Botón regresar -->
    <a href="{{ route('categorias.index') }}" class="btn-back">
        ⬅ Regresar al Listado de Categorías
    </a>

    <div class="container">
        <h1>Crear Categoría</h1>

        <form action="{{ route('categorias.store') }}" method="POST">
            @csrf

            <label>Nombre</label>
            <input type="text" name="nombre" placeholder="Escribe el nombre de la categoría..." required>

            <button type="submit" class="btn-primary">Guardar Categoría</button>
        </form>
    </div>

</body>
</html>
