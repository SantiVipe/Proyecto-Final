<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ventas = Venta::all();

        $ventasPorMes = array_fill(1, 12, 0);

        $ventasPorAño = [];
    
        $ventasProductos = [];
    
        foreach ($ventas as $venta) {
            $mes = Carbon::parse($venta->fecha_venta)->month;
            $año = Carbon::parse($venta->fecha_venta)->year;
            $ventasPorMes[$mes] += $venta->total;
            $ventasPorAño[$año] = ($ventasPorAño[$año] ?? 0) + $venta->total;
    
            foreach ($venta->productos as $prod) {
                $ventasProductos[$prod['nombre']] = ($ventasProductos[$prod['nombre']] ?? 0) + ($prod['cantidad'] * $prod['precio_unitario']);
            }
        }
    
        // Ordena años
        ksort($ventasPorAño);
        arsort($ventasProductos);
        $topProductos = array_slice($ventasProductos, 0, 5, true);
    
        return view('home', [
            'ventasHoy' => Venta::whereDate('fecha_venta', today())->sum('total'),
            'ventasMes' => Venta::whereYear('fecha_venta', now()->year)->whereMonth('fecha_venta', now()->month)->sum('total'),
            'mesesLabels' => ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            'ventasMesData' => array_values($ventasPorMes),
            'añoLabels' => array_keys($ventasPorAño),
            'ventasAñoData' => array_values($ventasPorAño),
            'productoLabels' => array_keys($topProductos),
            'ventasProductoData' => array_values($topProductos),
        ]);
    }
}
