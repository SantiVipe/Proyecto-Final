@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Lista de Clientes</h3>
            <a href="{{ route('clientes.create') }}" class="btn btn-success tt" title="Agregar Cliente"><i class="fa-solid fa-user-plus"></i></a>
        </div>

        {{-- Formulario de búsqueda --}}
        <form method="GET" action="{{ route('clientes.index') }}">
            <div class="form-group d-flex mb-2">
                <input type="text" name="buscar" class="form-control mr-2" placeholder="Buscar por nombre o cédula..." value="{{ request('buscar') }}">
                <button class="btn btn-outline-secondary mr-2 tt" type="submit" title="Buscar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <a href="{{ route('clientes.index') }}" class="btn btn-outline-danger tt" title="Limpiar Filtro">
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
                        <th>Nombre</th>
                        <th>Cédula</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->cedula }}</td>
                            <td>{{ $cliente->direccion }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td class="text-center">
                                <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-info tt" title="Ver Cliente"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning tt" title="Editar Cliente"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger tt" title="Eliminar Cliente"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay clientes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($clientes instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-3 d-flex justify-content-center">
                {{ $clientes->appends(request()->all())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
