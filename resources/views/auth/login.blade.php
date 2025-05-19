<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('assets/style.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
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
                <form method="POST" action="{{ route('login.post') }}">
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
                        <label for="email">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Correo electrónico" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Contraseña" required>
                    </div>

                    <button type="submit" class="btn btn-dark">Acceder</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
