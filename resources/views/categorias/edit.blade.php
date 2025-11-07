<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Categoría</title>

<style>
    body {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Inter, sans-serif;
        background: #0f172a; /* Oscuro */
        margin: 0;
        padding: 40px;
        color: #e2e8f0;
    }

    /* Botón regresar */
    .btn-back {
        display: inline-block;
        background: #334155;
        color: #e2e8f0;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        transition: 0.2s;
        margin-bottom: 25px;
        font-weight: 500;
    }

    .btn-back:hover {
        background: #475569;
    }

    /* Tarjeta */
    .container {
        max-width: 550px;
        margin: auto;
        background: #1e293b; /* Azul oscuro */
        padding: 35px;
        border-radius: 18px;
        box-shadow: 0px 4px 20px rgba(0,0,0,0.4);
    }

    h1 {
        font-size: 28px;
        color: #f8fafc;
        font-weight: 700;
        margin-bottom: 25px;
    }

    label {
        display: block;
        color: #cbd5e1;
        font-size: 15px;
        margin-bottom: 6px;
        font-weight: 500;
    }

    input[type="text"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #475569;
        border-radius: 10px;
        font-size: 15px;
        margin-bottom: 22px;
        background: #0f172a;
        color: #f8fafc;
        transition: 0.2s;
    }

    input[type="text"]:focus {
        border-color: #6366f1;
        outline: none;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.4);
        background: #1e293b;
    }

    /* Botón actualizar */
    .btn-primary {
        width: 100%;
        background: #6366f1;
        border: none;
        padding: 14px;
        border-radius: 12px;
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
        margin-bottom: 10px;
    }

    .btn-primary:hover {
        background: #4f46e5;
    }

    /* Botón cancelar */
    .btn-cancel {
        width: 100%;
        background: #64748b;
        border: none;
        padding: 14px;
        border-radius: 12px;
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-cancel:hover {
        background: #475569;
    }
</style>
</head>

<body>
    <div class="container">
        <h1>Editar Categoría</h1>

        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="nombre">Nombre:</label>
            <input 
                type="text" 
                id="nombre" 
                name="nombre" 
                value="{{ $categoria->nombre }}"
                required
            >

            <button type="submit" class="btn-primary">Actualizar Categoría</button>
        </form>

        <a href="{{ route('categorias.index') }}">
            <button class="btn-cancel">Cancelar</button>
        </a>
    </div>

</body>
</html>


