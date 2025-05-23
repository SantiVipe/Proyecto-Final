<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8e8e8;
        }
        .reset-box {
            margin-top: 100px;
            background: #fff0f0;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(200, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="col-md-6 reset-box">
        <h3 class="text-center text-danger">Recuperar Contraseña</h3>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" class="form-control" name="email" required autofocus>
            </div>

            <button type="submit" class="btn btn-danger btn-block">Enviar enlace</button>
        </form>
    </div>
</div>
</body>
</html>
