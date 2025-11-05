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
    >

    <button type="submit">
        Actualizar
    </button>
</form>

<!-- Botón simple para volver -->
<a href="{{ route('categorias.index') }}">
    <button>
        Cancelar
    </button>
</a>
