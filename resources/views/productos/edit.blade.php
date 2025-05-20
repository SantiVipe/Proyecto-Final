@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <h3 class="text-center mb-4">Editar Producto</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('productos.update', $producto) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" id="codigo" class="form-control" value="{{ $producto->codigo }}" readonly>
            </div>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" class="form-control" value="{{ old('stock', $producto->stock) }}" min="0" required>
            </div>

            <div class="form-group">
                <label for="precio_venta">Precio de venta</label>
                <input type="number" id="precio_venta" name="precio_venta" class="form-control" step="0.01" min="0" value="{{ old('precio_venta', $producto->precio_venta) }}" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success ff" title="Actualizar Producto"><i class="fa-solid fa-arrow-up-from-bracket"></i></button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary tt" title="Volver"><i class="fa-solid fa-arrow-left"></i></a>
            </div>
        </form>
    </div>
</div>
@endsection
