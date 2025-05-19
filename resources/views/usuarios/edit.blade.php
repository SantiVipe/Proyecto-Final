<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=decive-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>
    @if($errors->any())
        <div style="color=red;">
            <ul>
                @foreach($errors all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('usuarios.update'), $usuario}}" method="POST">
        @csrf 
        @method('PUT')

        <div>
            <label for="identificacion">Identificacion</label>
            <input type="text" id="identificacion" name="identificacion" value="{{ $usuario->identificacion}}" readonly>
        </div>

        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="{{ $usuario->nombre}}" require>
        </div>

        <div>
            <label for="rol">Rol:</label>
            <select id="rol" name="rol" require>
                <option value="admin" {{$usuario->rol == 'admin' ? 'selected' : ''}}>Administrador</option>
                <option value="usuario" {{$usuario->rol == 'usuario' ? 'selected' : ''}}>Usuario</option>
            </select>
        </div>

        <div>
            <label for="password">Nueva Contraseña:</label>
            <input type="password" id="password" name="password">
        </div>

        <button type="submit">Actualizar Usuario</button>
        <a href="{{ route('usurios.index')}}">Cancelar</a>
    </form>
</body>
</html>