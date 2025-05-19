@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <h3 class="text-center mb-4">Detalles del Producto</h3>

        <div class="mb-3">
            <label class="font-weight-bold">Código:</label>
            <p class="border p-2 rounded">{{ $producto->codigo }}</p>
        </div>

        <div class="mb-3">
            <label class="font-weight-bold">Nombre:</label>
            <p class="border p-2 rounded">{{ $producto->nombre }}</p>
        </div>

        <div class="mb-3">
            <label class="font-weight-bold">Descripción:</label>
            <p class="border p-2 rounded">{{ $producto->descripcion ?? 'N/A' }}</p>
        </div>

        <div class="mb-3">
            <label class="font-weight-bold">Stock:</label>
            <p class="border p-2 rounded">{{ $producto->stock }}</p>
        </div>

        <div class="mb-4">
            <label class="font-weight-bold">Precio:</label>
            <p class="border p-2 rounded">${{ number_format($producto->precio_venta, 2) }}</p>
        </div>

        <a href="{{ route('productos.index') }}" class="btn btn-secondary btn-block">Volver</a>
    </div>
</div>
@endsection
