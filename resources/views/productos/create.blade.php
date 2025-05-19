@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <h3 class="text-center mb-4">Crear Producto</h3>

        <form method="POST" action="{{ route('productos.store') }}">
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

            <div class="form-group">
                <label for="nombre">Nombre del producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" min="0" value="{{ old('stock') }}" required>
            </div>

            <div class="form-group">
                <label for="precio_venta">Precio de venta</label>
                <input type="number" class="form-control" id="precio_venta" name="precio_venta" min="0" step="0.01" value="{{ old('precio_venta') }}" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success">Guardar Producto</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>
</div>
@endsection
