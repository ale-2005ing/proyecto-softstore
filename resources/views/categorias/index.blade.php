<h1>Listado de Categorías</h1>

<!-- Botón para crear nueva categoría -->
<a href="{{ route('categorias.create') }}">
    <button>Crear Categoría</button>
</a>

@foreach ($categorias as $categoria)
    <p>
        {{ $categoria->nombre }}

        <!-- Botón editar -->
        <a href="{{ route('categorias.edit', $categoria->id) }}">
            <button>Editar</button>
        </a>
    </p>
@endforeach
