<h1>Crear Categoría</h1>

<form action="{{ route('categorias.store') }}" method="POST">
    @csrf

    <label>Nombre</label>
    <input type="text" name="nombre">

    <button type="submit">
        Guardar
    </button>
</form>
