<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   // Esto busca el ultimo producto
        $ultimoProducto = Producto::orderBy('id', 'desc')->first();
        
        $nuevoCodigo = $ultimoProducto ? $ultimoProducto->id + 1 : 1;
        // Setea el codigo con ceros a la izquierda
        $codigoFormateado = str_pad($nuevoCodigo, 5, '0', STR_PAD_LEFT);

        return view('productos.create', compact('codigoFormateado'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Normaliza el nombre ingresado a minúsculas para comparar
        $nombreIngresado = strtolower($request->nombre);

        // Verificar si ya existe un nombre similar (sin importar mayúsculas/minúsculas)
        $existe = Producto::whereRaw('LOWER(nombre) = ?', [$nombreIngresado])->exists();

        if ($existe) {
            return back()->withErrors(['nombre' => 'Ya existe un producto con este nombre.'])->withInput();
        }

        $request->validate([
            'codigo' => 'required|unique:productos,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'precio_venta' => 'required|numeric|min:0',
            "stock" => 'nullable|integer|min:0',
        ]);

        Producto::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_venta' => $request->precio_venta,
            'stock' => $request->stock ?? 0,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
