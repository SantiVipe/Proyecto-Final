<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $stock_min = $request->input('stock_min');
        $stock_max = $request->input('stock_max');
        $precio_min = $request->input('precio_min');
        $precio_max = $request->input('precio_max');

        $productos = Producto::query()
            ->when($buscar, function ($query, $buscar) {
                return $query->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('codigo', 'like', "%{$buscar}%");
            })
            ->when(is_numeric($stock_min), function ($query) use ($stock_min) {
                return $query->where('stock', '>=', $stock_min);
            })
            ->when(is_numeric($stock_max), function ($query) use ($stock_max) {
                return $query->where('stock', '<=', $stock_max);
            })
            ->when(is_numeric($precio_min), function ($query) use ($precio_min) {
                return $query->where('precio_venta', '>=', $precio_min);
            })
            ->when(is_numeric($precio_max), function ($query) use ($precio_max) {
                return $query->where('precio_venta', '<=', $precio_max);
            })
            ->orderBy('id', 'asc')  // Productos más nuevos primero
            ->get( );

        return view('productos.index', compact('productos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'precio_venta' => 'required|numeric|min:0',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',

            'descripcion.string' => 'La descripción debe ser una cadena de texto.',

            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',

            'precio_venta.required' => 'El precio de venta es obligatorio.',
            'precio_venta.numeric' => 'El precio de venta debe ser un número.',
            'precio_venta.min' => 'El precio de venta no puede ser negativo.',
        ]);

        $last = Producto::latest('id')->first();
        $nextNumber = $last ? $last->id + 1 : 1;
        $codigo = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        Producto::create([
            'codigo' => $codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'precio_venta' => $request->precio_venta,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'precio_venta' => 'required|numeric|min:0',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',

            'descripcion.string' => 'La descripción debe ser una cadena de texto.',

            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',

            'precio_venta.required' => 'El precio de venta es obligatorio.',
            'precio_venta.numeric' => 'El precio de venta debe ser un número.',
            'precio_venta.min' => 'El precio de venta no puede ser negativo.',
        ]);

        $producto = Producto::findOrFail($id);

        $producto->update($request->only('nombre', 'descripcion', 'stock', 'precio_venta'));

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
