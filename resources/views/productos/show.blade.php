@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <h3 class="mb-4">Detalles del Producto</h3>

        <div class="form-group">
            <label><strong>Código:</strong></label>
            <p>{{ $producto->codigo }}</p>
        </div>
        <div class="form-group">
            <label><strong>Nombre:</strong></label>
            <p>{{ $producto->nombre }}</p>
        </div>
        <div class="form-group">
            <label><strong>Descripción:</strong></label>
            <p>{{ $producto->descripcion ?? 'No especificada' }}</p>
        </div>
        <div class="form-group">
            <label><strong>Stock:</strong></label>
            <p>{{ $producto->stock }}</p>
        </div>
        <div class="form-group">
            <label><strong>Precio:</strong></label>
            <p>${{ number_format($producto->precio_venta, 2) }}</p>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary tt" title="Volver"><i class="fa-solid fa-arrow-left"></i></a>
            <div>
                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning tt" title="Editar"><i class="fa-solid fa-pencil"></i></a>
                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger tt" title="Eliminar"><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
