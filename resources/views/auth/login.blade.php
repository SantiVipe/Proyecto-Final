<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/style.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #f8e8e8;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-form {
            background: #fff0f0;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 0 10px rgba(200, 0, 0, 0.1);
            margin-top: 100px;
        }

        .login-form h2 {
            color: #c55;
            margin-bottom: 30px;
            text-align: center;
        }

        .btn-dark {
            background-color: #b33;
            border: none;
        }

        .btn-dark:hover {
            background-color: #a22;
        }

        a {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #a22;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="col-md-6">
        <div class="login-form">
            <h2>Iniciar sesión</h2>
            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Correo electrónico" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Contraseña" required>
                </div>

                <button type="submit" class="btn btn-dark w-100">Acceder</button>

                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            </form>
        </div>
    </div>
</div>

@if (session('status'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session("status") }}',
        confirmButtonColor: '#b33',
    });
</script>
@endif

</body>
</html>
