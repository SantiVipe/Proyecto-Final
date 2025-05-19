<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=decive-width, initial-scale=1.0">
    <title>Lista de Ventas</title>
</head>

<body>
    <h1>Lista de Ventas</h1>

    @if (session('success'))
        <div style="color:green;">
            {{ sesseion('success')}}
        </div>
    @endif

    <a href="{{ route('ventas.create')}}">Crear Nueva Venta</a>
    
    <table>
        <thead>
            <tr>
                <th>Consecutivo</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)

                <tr>
                    <td>{{ $venta->consecutivo}}</td>
                    <td>{{ $venta->fecha}}</td>
                    <td>{{ $venta->cliente->nombre}}</td>
                    <td>{{ $venta->total}}</td>
                    <td>
                        <a href="{{ route('ventas.show', $venta)}}">Ver</a>
                        <a href="{{ route('ventas.edit', $venta)}}" >Editar</a>
                        <form action="{{ route('ventas.destroy'. $venta)}}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('¿Estás seguro de eliminar esta venta?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>