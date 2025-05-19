<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
</head>
<body>
    <h1>Crear Producto</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf

        <div>
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo" value="{{ $codigoFormateado }}" readonly>
        </div>

        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>

        <div>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
        </div>

        <div>
            <label for="precio_venta">Precio de Venta:</label>
            <input type="number" id="precio_venta" name="precio_venta" step="0.01" value="{{ old('precio_venta') }}" required>
        </div>

        <div>
            <label for="stock">Stock (opcional):</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}">
        </div>

        <button type="submit">Crear Producto</button>
        <a href="{{ route('productos.index') }}">Cancelar</a>
    </form>
</body>
</html>
