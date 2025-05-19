<DOCTYPE html>
<html lang= "es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
</head>
<body>
    <h1>Crear Usuario</h1>
    @if ($errors->any())
        <div style="color= red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
             </ul>
         </div>
    @endif

    <form action="{{route('usuarios.store')}}" method="POST">
        @csrf

        <div>
            <label for="identificacion">Identificacion:</label>
            <input type="text" id="nombre" name="nombre" value="{{old('nombre')}}" require>
        </div>

        <div>
            <label for="rol">Rol:</label>
            <select id="rol" name="rol" require>
                <option value="admin">Administrador</option>
                <option value="usuario">Usuario</option>
            </select>
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" require>
        </div>

        <button type="summit">Crear Usuario</button>
        <a href="{{ route('usuarios.index')}}">Cancelar</a>
    </form>
</body>
</html>