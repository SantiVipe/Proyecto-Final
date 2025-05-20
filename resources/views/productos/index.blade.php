@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Lista de Productos</h3>
            <a href="{{ route('productos.create') }}" class="btn btn-success tt" title="Agregar Producto"><i class="fa-solid fa-shop"></i></a>
        </div>

        {{-- Formulario de búsqueda --}}
        <form method="GET" action="{{ route('productos.index') }}">
            <div class="form-group d-flex mb-2">
                <input type="text" name="buscar" class="form-control mr-2" placeholder="Buscar por nombre o código..." value="{{ request('buscar') }}">
                
                <button class="btn btn-outline-primary mr-2 tt" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosAvanzados" aria-expanded="false" aria-controls="filtrosAvanzados" title="Filtrar">
                    <i class="fa-solid fa-filter"></i>
                </button>
                
                <button class="btn btn-outline-secondary mr-2 tt" type="submit" title="Buscar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                
                <a href="{{ route('productos.index') }}" class="btn btn-outline-danger tt" title="Limpiar Filtro">
                    <i class="fa-solid fa-eraser"></i>
                </a>
            </div>
            <div class="collapse {{ (request('stock_min') || request('stock_max') || request('precio_min') || request('precio_max')) ? 'show' : '' }}" id="filtrosAvanzados">
                <div class="card card-body mb-3">
                    <div class="form-row">
                        <div class="col-md-3 mb-2">
                            <input type="number" name="stock_min" min="0" class="form-control" placeholder="Stock mínimo" value="{{ request('stock_min') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="number" name="stock_max" min="0" class="form-control" placeholder="Stock máximo" value="{{ request('stock_max') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="number" step="0.01" min="0" name="precio_min" class="form-control" placeholder="Precio mínimo" value="{{ request('precio_min') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="number" step="0.01" min="0" name="precio_max" class="form-control" placeholder="Precio máximo" value="{{ request('precio_max') }}">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-container">
            <table class="table table-striped table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                        <tr>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>${{ number_format($producto->precio_venta, 2) }}</td>
                            <td class="text-center">
                                <a href="{{ route('productos.show', $producto) }}" class="btn btn-sm btn-info tt" title="Ver Producto"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning tt" title="Editar Producto"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger tt" title="Eliminar Producto"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
