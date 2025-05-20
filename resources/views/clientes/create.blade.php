@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <h3 class="mb-4">Nuevo Cliente</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>
            <div class="form-group">
                <label for="cedula">Cédula</label>
                <input type="text" name="cedula" class="form-control" value="{{ old('cedula') }}" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
            </div>
            <div class="mt-4 d-flex justify-content-between">
                <button type="submit" class="btn btn-success tt" title="Guardar Cliente"><i class="fa-solid fa-floppy-disk"></i></button>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary tt" title="Volver"><i class="fa-solid fa-arrow-left"></i></a>
            </div>
        </form>
    </div>
</div>
@endsection
