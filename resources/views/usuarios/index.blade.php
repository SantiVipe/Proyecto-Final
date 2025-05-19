<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
</head>
<body>
    <h1>Usuarios</h1>

    @if (session('success'))
    <div style="color: blue;">
        {{session('success')}}
    </div>
    @endif

    @if (Auth::user()->rol == 'admin')
    <a href="{{route('usuarios.create')}}">Crear Nuevo Usuario </a>
    @endif


    <table>
    <thead>
    <tr>
        <th>identificacion</th>
        <th>Nombre</th>
        <th>Rol</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($usuarios as $usuario)
    <tr>
        <td>{{$usuario->identificacion}}</td>
        <td>{{$usuario->nombre}}</td>
        <td>{{$usuario->rol}}</td>
        <td>
            <a hred="{{ route('usuarios.edit', $usuario)}}">Editar</a>
            <form action="{{ route('usuarios.destroy', $usuario)}}" method= "Post" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
    </table>
</body>
</html>