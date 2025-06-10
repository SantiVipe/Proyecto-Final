<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $ventas = Venta::with(['cliente', 'usuario'])
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->buscar;
                $query->where(function($q) use ($buscar) {
                    $q->whereHas('usuario', function ($q2) use ($buscar) {
                        $q2->where('nombre', 'like', '%' . $buscar . '%');
                    })
                    ->orWhereHas('cliente', function ($q3) use ($buscar) {
                        $q3->where('cedula', 'like', '%' . $buscar . '%');
                    });
                });
            })
            ->when($request->filled('fecha'), function ($query) use ($request) {
                $query->whereDate('fecha_venta', $request->fecha);
            })
            ->orderBy('fecha_venta', 'desc')
            ->get();

        return view('ventas.index', compact('ventas'));
    }
    
    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ventas.create', compact('clientes','productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:1',
        ], [
            'cliente_id.required' => 'Debe seleccionar un cliente.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',

            'productos.required' => 'Debe agregar al menos un producto.',
            'productos.array' => 'El formato de los productos no es válido.',
            'productos.min' => 'Debe agregar al menos un producto.',

            'productos.*.producto_id.required' => 'Debe seleccionar un producto.',
            'productos.*.producto_id.exists' => 'El producto seleccionado no existe.',

            'productos.*.cantidad.required' => 'Debe indicar la cantidad.',
            'productos.*.cantidad.numeric' => 'La cantidad debe ser un número.',
            'productos.*.cantidad.min' => 'La cantidad mínima es 1.',
        ]);

        try {
            DB::beginTransaction();

            $venta = new Venta();
            $venta->consecutivo = Str::uuid();
            $venta->cliente_id = $request->cliente_id;
            $venta->usuario_id = auth()->id();
            $venta->fecha_venta = now(); 
            $venta->fecha_fin_garantia = now()->addYears(2);

            $total = 0;
            $productos_guardados = [];

            foreach ($request->productos as $producto) {
                $producto_db = Producto::findOrFail($producto['producto_id']);

                if ($producto_db->stock < $producto['cantidad']) {
                    throw new \Exception("No hay suficiente stock para el producto {$producto_db->nombre}");
                }

                $precio_unitario = $producto_db->precio_venta;
                $subtotal = $precio_unitario * $producto['cantidad'];

                $productos_guardados[] = [
                    'producto_id' => $producto_db->id,
                    'nombre' => $producto_db->nombre,
                    'precio_unitario' => $precio_unitario,
                    'cantidad' => $producto['cantidad'],
                    'subtotal' => $subtotal,
                ];

                // Descontar stock
                $producto_db->stock -= $producto['cantidad'];
                $producto_db->save();

                $total += $subtotal;
            }

            // Guardar productos y total
            $venta->productos = $productos_guardados;
            $venta->total = $total;
            $venta->save();

            DB::commit();

            return redirect()->route('ventas.index')->with('success', 'Venta registrada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Ocurrió un error al guardar la venta: ' . $e->getMessage())->withInput();
        }
    }



    public function show($id)
    {
        // Obtener la venta
        $venta = Venta::with('usuario', 'cliente')->findOrFail($id);

        // Obtener todos los productos de la venta (el campo 'productos' es JSON decodificado en array)
        $productosDetalles = $venta->productos; // ya es array si lo tienes cast como json o decodificas

        // Obtener IDs de productos para cargar sus nombres de forma eficiente
        $productosIds = collect($productosDetalles)->pluck('producto_id')->toArray();

        // Traer los productos de la base, indexados por ID
        $productos = Producto::whereIn('id', $productosIds)->get()->keyBy('id');

        return view('ventas.show', compact('venta', 'productos'));
    }

    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:1',
        ], [
            'cliente_id.required' => 'Debe seleccionar un cliente.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',

            'productos.required' => 'Debe agregar al menos un producto.',
            'productos.array' => 'El formato de los productos no es válido.',
            'productos.min' => 'Debe agregar al menos un producto.',

            'productos.*.producto_id.required' => 'Debe seleccionar un producto.',
            'productos.*.producto_id.exists' => 'El producto seleccionado no existe.',

            'productos.*.cantidad.required' => 'Debe indicar la cantidad.',
            'productos.*.cantidad.numeric' => 'La cantidad debe ser un número.',
            'productos.*.cantidad.min' => 'La cantidad mínima es 1.',
        ]);

        try {
            DB::beginTransaction();

            $productosAnteriores = $venta->productos;
            if ($productosAnteriores) {
                foreach ($productosAnteriores as $productoAnterior) {
                    $productoAnteriorDb = Producto::find($productoAnterior['producto_id']);
                    if ($productoAnteriorDb) {
                        $productoAnteriorDb->stock += $productoAnterior['cantidad'];
                        $productoAnteriorDb->save();
                    }
                }
            }

            $venta->cliente_id = $request->cliente_id;
            $venta->usuario_id = auth()->id();
            $total = 0;
            $productos_para_guardar = [];

            foreach ($request->productos as $producto) {
                $producto_db = Producto::findOrFail($producto['producto_id']);

                if ($producto_db->stock < $producto['cantidad']) {
                    throw new \Exception("No hay suficiente stock para el producto {$producto_db->nombre}");
                }

                $precioUnitario = $producto_db->precio_venta;
                $subtotal = $producto['cantidad'] * $precioUnitario;
                $total += $subtotal;

                $productos_para_guardar[] = [
                    'producto_id' => $producto['producto_id'],
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $precioUnitario,
                    'subtotal' => $subtotal,
                ];

                $producto_db->stock -= $producto['cantidad'];
                $producto_db->save();
            }

            $venta->productos = $productos_para_guardar;
            $venta->total = $total;
            $venta->save();

            DB::commit();

            return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }


    public function edit($id)
    {
        $venta = Venta::findOrFail($id);
        $clientes = Cliente::all();
        $productos = Producto::all();

        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    public function destroy(Venta $venta)
    {
        try {
            DB::beginTransaction();

            $productosAnteriores = is_string($venta->productos)
                ? json_decode($venta->productos, true)
                : $venta->productos;

            if ($productosAnteriores) {
                foreach ($productosAnteriores as $producto) {
                    $productoDb = Producto::find($producto['producto_id']);
                    if ($productoDb) {
                        $productoDb->stock += $producto['cantidad'];
                        $productoDb->save();
                    }
                }
            }

            $venta->delete();

            DB::commit();

            return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al eliminar la venta: ' . $e->getMessage()]);
        }
    }
}
