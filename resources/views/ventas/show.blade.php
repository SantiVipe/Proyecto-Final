@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <h3 class="mb-4">Detalles de la Venta</h3>

        <div class="venta-details" style="max-height: calc(100vh - 250px); overflow-y: auto; padding-right: 10px;">
            <div class="form-group">
                <label><strong>Número de Venta:</strong></label>
                <p>#{{ $venta->id }}</p>
            </div>
            <div class="form-group">
                <label><strong>Cliente:</strong></label>
                <p>{{ $venta->cliente->nombre ?? 'N/A' }}</p>
            </div>
            <div class="form-group">
                <label><strong>Fecha de venta:</strong></label>
                <p>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') }}</p>
            </div>
            <div class="form-group">
                <label><strong>Garantía válida hasta:</strong></label>
                <p>{{ $venta->fecha_fin_garantia ? \Carbon\Carbon::parse($venta->fecha_fin_garantia)->format('d/m/Y') : 'No registrada' }}</p>
            </div>
            <div class="form-group">
                <label><strong>Registrado por:</strong></label>
                <p>{{ $venta->usuario->nombre ?? 'N/A' }}</p>
            </div>

            <div class="form-group">
                <label><strong>Productos:</strong></label>
                <table class="table table-bordered mt-2">
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
            </div>

            <div class="form-group">
                <label><strong>Total:</strong></label>
                <p>${{ number_format($venta->total, 2) }}</p>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary tt" title="Volver"><i class="fa-solid fa-arrow-left"></i></a>
            <div>
                <a href="{{ route('ventas.edit', $venta) }}" class="btn btn-warning" title="Editar"><i class="fa-solid fa-pencil"></i></a>
                <form action="{{ route('ventas.destroy', $venta) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar esta venta?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" title="Eliminar"><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
