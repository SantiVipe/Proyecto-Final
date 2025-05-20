@extends('layouts.app')

@section('content')
<div class="fixed-box bg-light p-4 rounded mx-auto" style="max-width: 800px; max-height: 90vh; overflow-y: auto;">
    <h2>Detalle de Venta #{{ $venta->id }}</h2>

    <p><strong>Cliente:</strong> {{ $venta->cliente->nombre ?? 'N/A' }}</p>
    <p><strong>Fecha de venta:</strong> {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') }}</p>
    <p><strong>Garantía válida hasta:</strong> 
        {{ $venta->fecha_garantia ? \Carbon\Carbon::parse($venta->fecha_garantia)->format('d/m/Y') : 'No registrada' }}
    </p>
    <p><strong>Registrado por:</strong> {{ $venta->usuario->nombre ?? 'N/A' }}</p>

    <table class="table table-bordered mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Producto</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->productos as $detalle)
                <tr>
                    <td>{{ $detalle['nombre'] ?? 'Producto eliminado' }}</td>
                    <td>${{ number_format($detalle['precio_unitario'], 2) }}</td>
                    <td>{{ $detalle['cantidad'] }}</td>
                    <td>${{ number_format($detalle['subtotal'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="mt-3"><strong>Total:</strong> ${{ number_format($venta->total, 2) }}</p>
</div>
@endsection
