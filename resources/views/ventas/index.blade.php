@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Lista de Ventas</h3>
            <a href="{{ route('ventas.create') }}" class="btn btn-success tt" title="Registrar Venta"><i class="fa-solid fa-cash-register"></i></a>
        </div>

        {{-- Formulario de búsqueda y filtro --}}
        <form method="GET" action="{{ route('ventas.index') }}">
            <div class="form-group d-flex mb-2">
                <input type="text" name="buscar" class="form-control mr-2" placeholder="Buscar por usuario o cédula del cliente..." value="{{ request('buscar') }}">
                <input type="date" name="fecha" class="form-control mr-2" value="{{ request('fecha') }}">
                <button class="btn btn-outline-secondary mr-2 tt" type="submit" title="Buscar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <a href="{{ route('ventas.index') }}" class="btn btn-outline-danger tt" title="Limpiar Filtro">
                    <i class="fa-solid fa-eraser"></i>
                </a>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-container">
            <table class="table table-striped table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Cliente</th>
                        <th>Cédula</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Garantía</th>
                        <th>Total</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->cliente->nombre }}</td>
                            <td>{{ $venta->cliente->cedula }}</td>
                            <td>{{ $venta->usuario->nombre ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($venta->fecha_fin_garantia)->format('d/m/Y') }}</td>
                            <td>${{ number_format($venta->total, 2) }}</td>
                            <td class="text-center">
                                <a href="{{ route('ventas.show', $venta) }}" class="btn btn-sm btn-info tt" title="Ver Detalles"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-sm btn-warning tt" title="Editar Venta"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('ventas.destroy', $venta) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta venta?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger tt" title="Eliminar Venta"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay ventas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
