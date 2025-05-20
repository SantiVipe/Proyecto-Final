@extends('layouts.app')

@section('content')
<div class="main">
    <div class="fixed-box">
        <h3 class="text-center mb-4">Registrar Venta</h3>

        <form method="POST" action="{{ route('ventas.store') }}">
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
                <label for="cliente_id">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Productos</label>
                <div id="productos-container">
                    <div class="d-flex mb-2">
                        <select name="productos[0][producto_id]" class="form-control mr-2" required>
                            <option value="">Seleccione</option>
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}">
                                    {{ $producto->nombre }} - ${{ number_format($producto->precio_venta, 2) }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="productos[0][cantidad]" class="form-control" placeholder="Cantidad" min="1" required>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-primary mt-2" onclick="agregarProducto()">Agregar otro producto</button>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i></button>
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i></a>
            </div>
        </form>
    </div>
</div>

<script>
let productoIndex = 1;
function agregarProducto() {
    const container = document.getElementById('productos-container');
    const div = document.createElement('div');
    div.classList.add('d-flex', 'mb-2');
    div.innerHTML = `
        <select name="productos[${productoIndex}][producto_id]" class="form-control mr-2" required>
            <option value="">Seleccione</option>
            @foreach ($productos as $producto)
                <option value="{{ $producto->id }}">{{ $producto->nombre }} - ${{ number_format($producto->precio_venta, 2) }}</option>
            @endforeach
        </select>
        <input type="number" name="productos[${productoIndex}][cantidad]" class="form-control" placeholder="Cantidad" min="1" required>
    `;
    container.appendChild(div);
    productoIndex++;
}
</script>
@endsection
