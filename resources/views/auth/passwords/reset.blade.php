<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
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
        <h3 class="text-center text-danger">Restablecer Contraseña</h3>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

            <div class="form-group">
                <label>Nueva contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-danger btn-block">Restablecer</button>
        </form>
    </div>
</div>
</body>
</html>
