<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/71e9100085.js" crossorigin="anonymous"></script>

    <style>
        .navbar-custom {
            background-color: #f5ebe0;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom .dropdown-item {
            color: #a64b4b;
            font-weight: 600;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .dropdown-item:hover {
            color: #7a3636;
            background-color: #d9cfc8;
        }
        .navbar-custom .dropdown-menu {
            background-color: #f5ebe0;
            border: none;
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
                <a class="navbar-brand" href="{{ url('/home') }}">{{ config('app.name', 'Laravel') }}</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        @foreach (['productos' => 'Productos', 'clientes' => 'Clientes', 'ventas' => 'Ventas'] as $route => $label)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="{{ $route }}Dropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">{{ $label }}</a>
                                <ul class="dropdown-menu" aria-labelledby="{{ $route }}Dropdown">
                                    <li><a class="dropdown-item" href="{{ route($route . '.index') }}">Listar {{ $label }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route($route . '.create') }}">Crear {{ rtrim($label, 's') }}</a></li>
                                </ul>
                            </li>
                        @endforeach

                        @auth
                            @if (Auth::user()->rol === 'admin')
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="usuariosDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">Usuarios</a>
                                    <ul class="dropdown-menu" aria-labelledby="usuariosDropdown">
                                        <li><a class="dropdown-item" href="{{ route('usuarios.index') }}">Listar Usuarios</a></li>
                                        <li><a class="dropdown-item" href="{{ route('usuarios.create') }}">Crear Usuarios</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endauth
                    </ul>

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
                                            <button type="submit" class="dropdown-item" style="background: none; border: none; padding: 0;">
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
            @if(Route::currentRouteName() == 'home' && isset($ventasPorMes))
                <div class="container">
                    <h2 class="mb-4">Dashboard de Ventas</h2>

                    @if($ventasPorMes->isEmpty())
                        <div class="alert alert-info">
                            <h4 class="alert-heading">¡Bienvenido al Dashboard!</h4>
                            <p>No hay datos de ventas disponibles todavía. Los gráficos se mostrarán cuando se registren ventas en el sistema.</p>
                            <hr>
                            <p class="mb-0">Puedes comenzar registrando una nueva venta desde el menú "Ventas".</p>
                        </div>
                    @else
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Ventas del Día</h5>
                                        <h3 class="card-text">${{ number_format($ventasHoy ?? 0, 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Ventas del Mes</h5>
                                        <h3 class="card-text">${{ number_format($ventasMes ?? 0, 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Ventas por Mes</h5>
                                        <canvas id="ventasPorMesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Top 5 Productos</h5>
                                        <canvas id="topProductosChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @push('scripts')
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            new Chart(document.getElementById('ventasPorMesChart').getContext('2d'), {
                                type: 'line',
                                data: {
                                    labels: {!! json_encode($ventasPorMes->pluck('mes')) !!},
                                    datasets: [{
                                        label: 'Ventas por Mes',
                                        data: {!! json_encode($ventasPorMes->pluck('total_ventas')) !!},
                                        borderColor: '#a64b4b',
                                        tension: 0.1,
                                        fill: false,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: { beginAtZero: true }
                                    }
                                }
                            });

                            new Chart(document.getElementById('topProductosChart').getContext('2d'), {
                                type: 'doughnut',
                                data: {
                                    labels: {!! json_encode($topProductos->pluck('nombre')) !!},
                                    datasets: [{
                                        data: {!! json_encode($topProductos->pluck('total_vendido')) !!},
                                        backgroundColor: ['#a64b4b', '#b23b3b', '#922d2d', '#7a3636', '#5c2a2a']
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: { legend: { position: 'bottom' } }
                                }
                            });
                        </script>
                        @endpush
                    @endif
                </div>
            @else
                @yield('content')
            @endif
        </main>
    </div>

    <script>
        // Inicializa tooltips de Bootstrap
        document.querySelectorAll('.tt').forEach(t => new bootstrap.Tooltip(t));
    </script>
    @stack('scripts')
</body>
</html>
