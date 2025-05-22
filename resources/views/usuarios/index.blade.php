@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Lista de Usuarios</h3>
            <a href="{{ route('usuarios.create') }}" class="btn btn-success tt" title="Agregar Usuario"><i class="fa-solid fa-shop"></i></a>
        </div>
        <form method="GET" action="{{ route('usuarios.index') }}">
            <div class="form-group d-flex mb-2">
                <input type="text" name="buscar" class="form-control mr-2" placeholder="Buscar por Cédula o por Email..." value="{{ request('buscar') }}">

                <button class="btn btn-outline-secondary mr-2 tt" type="submit" title="Buscar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                
                <a href="{{ route('productos.index') }}" class="btn btn-outline-danger tt" title="Limpiar Filtro">
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
                        <th>Cedula</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->cedula }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>{{ $usuario->rol }}</td>
                            <td class="text-center">
                                <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-sm btn-info tt" title="Ver Usuario"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-warning tt" title="Editar Usuario"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="d-inline-block" onsubmit="return ('¿Estás seguro de eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger tt" title="Eliminar Usuario"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection