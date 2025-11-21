<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Categorías</title>

    <style>
        body {
            background: #111827;
            font-family: Arial, sans-serif;
            padding: 30px;
            color: white;
        }

        .container {
            background: #1f2937;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 0 15px rgba(0,0,0,0.6);
            width: 70%;
            margin: 0 auto;
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
            color: #60a5fa;
            margin-bottom: 20px;
        }

        .btn-back, .btn-primary {
            padding: 10px 18px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-back {
            background: #374151;
            color: #e5e7eb;
            margin-bottom: 20px;
        }

        .btn-back:hover {
            background: #4b5563;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            margin-bottom: 25px;
        }

        .btn-primary:hover {
            background: #1e40af;
        }

        .category-item {
            background: #111827;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #374151;
        }

        .btn-edit {
            background: #10b981;
            color: white;
            padding: 7px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-edit:hover {
            background: #059669;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
            padding: 7px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            margin-left: 10px;
        }

        .btn-delete:hover {
            background: #b91c1c;
        }
    </style>
</head>

<body>

<div class="container">

    {{-- ALERTA DE ÉXITO --}}
    @if (session('success'))
        <div style="background: #16a34a; color: white; padding: 12px; border-radius: 10px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- BOTÓN VOLVER --}}
    <a href="{{ route('dashboard') }}">
        <button class="btn-back">⬅ Volver al Dashboard</button>
    </a>

    <h1>Listado de Categorías</h1>

    {{-- BOTÓN CREAR --}}
    <a href="{{ route('categorias.create') }}">
        <button class="btn-primary">+ Crear Categoría</button>
    </a>

    {{-- LISTADO DE CATEGORÍAS --}}
    @foreach ($categorias as $categoria)
        <div class="category-item">
            <span>{{ $categoria->nombre }}</span>

            <div>
                <a href="{{ route('categorias.edit', $categoria->id) }}">
                    <button class="btn-edit">Editar</button>
                </a>

                <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete"
                        onclick="return confirm('¿Seguro que deseas eliminar esta categoría?')">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    @endforeach

</div>

</body>
</html>
