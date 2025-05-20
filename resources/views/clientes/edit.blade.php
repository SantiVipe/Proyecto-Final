@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <h3 class="mb-4">Editar Cliente</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clientes.update', $cliente) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $cliente->nombre) }}" required>
            </div>
            <div class="form-group">
                <label for="cedula">Cédula</label>
                <input type="text" name="cedula" class="form-control" value="{{ old('cedula', $cliente->cedula) }}" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $cliente->direccion) }}">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono) }}">
            </div>
            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('clientes.index') }}" class="btn btn-outline-danger tt" title="Volver"><i class="fa-solid fa-arrow-left"></i></a>
                <button type="submit" class="btn btn-warning ff" title="Actualizar Cliente"><i class="fa-solid fa-arrow-up-from-bracket"></i></button>
            </div>
        </form>
    </div>
</div>
@endsection
