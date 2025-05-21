<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Fonts / Nunito -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/71e9100085.js" crossorigin="anonymous"></script>

    <style>
        /* Estilos personalizados */
        .navbar-custom {
            background-color: #f5ebe0;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #a64b4b;
            font-weight: 600;
        }
        .navbar-custom .nav-link:hover {
            color: #7a3636;
        }
        .navbar-custom .dropdown-menu {
            background-color: #f5ebe0;
            border: none;
        }
        .navbar-custom .dropdown-item {
            color: #a64b4b;
        }
        .navbar-custom .dropdown-item:hover {
            background-color: #d9cfc8;
            color: #7a3636;
        }

        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 100px);
            padding: 30px 0;
        }

        .fixed-box {
            width: 90%;
            max-width: 1000px;
            height: 600px;
            background-color: #fcebe4;
            border: 2px solid #b23b3b;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .fixed-box h3 {
            color: #b23b3b;
        }

        .table-container {
            flex: 1;
            overflow-y: auto;
            margin-top: 10px;
        }

        .table thead {
            position: sticky;
            top: 0;
            background-color: #f8d3c8;
        }

        .btn-success, .btn-info, .btn-warning, .btn-danger {
            border-radius: 10px;
        }

        .btn-success {
            background-color: #a94442;
            border: none;
        }

        .btn-success:hover {
            background-color: #922d2d;
        }

        .table-container::-webkit-scrollbar {
            width: 10px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background-color: #b23b3b;
            border-radius: 5px;
        }

        .table-container::-webkit-scrollbar-track {
            background-color: #fcebe4;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-custom shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <!-- Productos -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="productosDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Productos</a>
                            <ul class="dropdown-menu" aria-labelledby="productosDropdown">
                                <li><a class="dropdown-item" href="{{ route('productos.index') }}">Listar Productos</a></li>
                                <li><a class="dropdown-item" href="{{ route('productos.create') }}">Crear Producto</a></li>
                            </ul>
                        </li>
                        <!-- Clientes -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="clientesDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Clientes</a>
                            <ul class="dropdown-menu" aria-labelledby="clientesDropdown">
                                <li><a class="dropdown-item" href="{{ route('clientes.index') }}">Listar Clientes</a></li>
                                <li><a class="dropdown-item" href="{{ route('clientes.create') }}">Crear Cliente</a></li>
                            </ul>
                        </li>
                        <!-- Ventas -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="ventasDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Ventas</a>
                            <ul class="dropdown-menu" aria-labelledby="ventasDropdown">
                                <li><a class="dropdown-item" href="{{ route('ventas.index') }}">Listar Ventas</a></li>
                                <li><a class="dropdown-item" href="{{ route('ventas.create') }}">Crear Venta</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="usuariosDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Usuarios</a>
                            <ul class="dropdown-menu" aria-labelledby="usuariosDropdown">
                                <li><a class="dropdown-item" href="{{ route('usuarios.index') }}">Listar Usuarios</a></li>
                                <li><a class="dropdown-item" href="{{ route('usuarios.create') }}">Crear Usuarios</a></li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Auth Links -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item" style="background: none; border: none; padding: 0; margin: 0;">
                                                {{ __('Logout') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5 Bundle JS (con Popper incluido) -->
    <!-- Tooltips manuales -->
    <script>
        document.querySelectorAll('.tt').forEach(t => {
            new bootstrap.Tooltip(t);
        });
    </script>
    <script src="https://kit.fontawesome.com/71e9100085.js" crossorigin="anonymous"></script>
</body>
</html>
