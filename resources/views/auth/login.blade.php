<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <!-- Tu CSS personalizado -->
    <link href="assets/style.css" rel="stylesheet">

    <!-- jQuery y Bootstrap JS -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="sidenav">
        <div class="login-main-text">
            <h2>Página de inicio<br> del cafeterito</h2>
            <p>Inicie sesión para acceder.</p>
        </div>
    </div>
    <div class="main">
        <div class="col-md-6 col-sm-12">
            <div class="login-form">
                <form method="POST" action="{{route('login.post')}}">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for ="identificacion">Nombre de Usuario(Identificacion)</label>
                        <input type="text" class="form-control" id="identificacion" name="identificacion" placeholder="Nombre de Usuario" value="{{ old('identificacion')}}" requiered autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseñas</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                    </div>

                    <button type="submit" class="btn btn-black">Acceso</button>\
                    <button type="button" href='' class="btn btn-black">Acceso</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
