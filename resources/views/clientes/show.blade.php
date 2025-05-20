@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <h3 class="mb-4">Detalles del Cliente</h3>

        <div class="form-group">
            <label><strong>Nombre:</strong></label>
            <p>{{ $cliente->nombre }}</p>
        </div>
        <div class="form-group">
            <label><strong>Cédula:</strong></label>
            <p>{{ $cliente->cedula ?? 'No especificada' }}</p>
        </div>
        <div class="form-group">
            <label><strong>Dirección:</strong></label>
            <p>{{ $cliente->direccion ?? 'No especificada' }}</p>
        </div>
        <div class="form-group">
            <label><strong>Teléfono:</strong></label>
            <p>{{ $cliente->telefono ?? 'No especificado' }}</p>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">Volver</a>
            <div>
                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
