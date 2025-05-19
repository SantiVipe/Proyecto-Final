<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminare\Support\Str;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::all();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = \App\Models\Cliente::all();
        $productos = Producto::all();
        return view('ventas.create', compact('clientes','productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'=>'required|exists:clientes,id',
            'fecha'=> 'required|date',
            'productos'=> 'required|array',
            'productos.*.producto_id'=>'required|exists:productos,id',
            'productos.*.cantidad'=> 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $consecutivo= Str::uuid();

            $venta = new Venta();
            $venta->consecutivo = $consecutivo;
            $venta->cliente_id = $request->cliente_id;
            $venta->fecha = $request->fecha;

            $total = 0;
            $productos_para_guardar = [];
            foreach ($request->productos as $producto) {
                $producto_db = Producto::find($producto['producto_id']);
                if ($producto_db->stock < $product['cantidad']){
                    throw new \Exception("No hay suficiente stock del producto {$producto_db->nombre}");
                }
                $subtotal = $producto['cantidad'] * $producto['precio_unitario'];
                $total +=$subtotal;
                $productos_para_guardar[]=['producto_id'=>$producto['producto_id'], 'cantidad'=> $producto['cantidad'], 'precio_unitario'=> $producto['precio_unitario'], 'subtotal'=> $subtotal,
            ];
                $producto_db->stock -= $producto['cantidad'];
                $producto_db->save();
            }
            $venta->total =$total;
            $venta->productos = json_encode($productos_para_guardar);
            $venta->save();

            DB::commit();
            return redirect()->route('ventas.index')->with('success','Venta creada exitosamente');   
        } catch (\Exception $e){
            DB::rollBack();
            return back()->withErrors(['error'=> $e->getMessage()])->withInput();
        }
        
    }
    public function show(Venta $venta)
    {
        $venta->cliente;
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $clientes = \App\Models\Cliente::all();
        $productos = Producto::all();
        return view('ventas.edit', compact('venta', 'clientes', 'productos'));
    }

    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'cliente_id'=>'required|exist:clientes,id',
            'fecha'=> 'required|date',
            'productos.*.producto_id'=> 'required|exist:productos,id',
            'productos.*.cantidad'=> 'required|integer|min:1',
            'productos.*.precio_unitario'=> 'required|numeric|min:0',
        ]);

        try{
            DB::beginTransaction();

            $venta->cliente_id =$request->cliente_id;
            $venta->fecha = $request->fecha;

            $total=0;
            $productos_para_guardar=[];
            foreach ($request->productos as $producto){
                $producto_db = Producto::find($producto['producto_id']);
                if ($producto_db->stock <$producto['cantidad']){
                    throw new \Exception("No hay producto en existencia {$producto_db->nombre}");
                }
                $subtotal = $producto['cantidad']* $producto['precio_unitario'];
                $total += $subtotal;

                $productos_para_guardar[]=[
                    'producto_id' => $producto['producto_id'],
                    'cantidad'=> $producto['cantidad'],
                    'precio_unitario'=>$producto['precio_unitario'],
                    'subtotal'=> $subtotal,
                ];

                $producto_db->stock -= $producto['cantidad'];
                $producto_db->save();
            }

            $productosAnteriores = json_decode($venta->productos, true);
            if ($productosAnteriores){
                foreach ($productosAnteriores as $productoAnterior){
                    $productoAnteriorDb = Producto::find($productoAnterior['producto_id']);
                    if ($productoAnteriorDb){
                        $productoAnteriorDb->stock += $productoAnterior['cantidad'];
                        $productoAnteriorDb->save();
                    }
                }
            }

            $venta->total =$total;
            $venta->productos = json_encode($productos_para_guardar);
            $venta->save();

            DB::commit();
            return redirect()->route('ventas.index')->with('success', 'Venta Actualizada Exitosamente');
        } catch (\Exception $e){
            DB::rollBack();
            return back()->withErrors(['error'=> $e->getMessage()])->withInput();
        }
    }

    public function destroy( Venta $venta)
    {
        try {
            DB::beginTRansaction();

            $productosAnteriores = json_decode($venta->productos, true);
            if ($productosAnteriores){
                foreach($productosAnteriores as $producto){
                    $productoDb = Producto::find($producto['producto_id']);
                    if ($productoDb){
                        $productoDb->stock += $producto['cantidad'];
                        $productoDb->save();
                    }
                }
            }
            $venta->delete();
            DB::commit();

            return redirect()->route('ventas.index')->with('success','Venta Eliminada Exitosamente');
        } catch (\Exception $e){
            DB::rollBack();
            return back()->withErrors(['error'=> $e->getMessage()])->withInput();
        }
    }
}

