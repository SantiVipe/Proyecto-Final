<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Proveedores</title>
</head>
<body>
    <h1>Lista de Proveedores</h1>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <p><a href="{{ route('proveedores.create') }}">Crear Nuevo Proveedor</a></p>

    @if ($proveedores->isEmpty())
        <p>No hay proveedores registrados.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Plazo de Pago (días)</th>
                    <th>Último Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->id }}</td>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->direccion ?? '-' }}</td>
                        <td>{{ $proveedor->telefono ?? '-' }}</td>
                        <td>{{ $proveedor->plazo_pago ?? '-' }}</td>
                        <td>{{ $proveedor->fecha_ultimo_pago ?? '-' }}</td>
                        <td>
                            <a href="{{ route('proveedores.show', $proveedor) }}">Ver</a> |
                            <a href="{{ route('proveedores.edit', $proveedor) }}">Editar</a> |
                            <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>