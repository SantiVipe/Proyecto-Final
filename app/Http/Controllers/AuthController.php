<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->rol === 'admin') {
                return redirect()->intended('/home');
            } else {
                return redirect()->route('empleado.dashboard'); // crea una ruta simple para ellos
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con ningún usuario.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function home()
    {
        // Ventas por mes del año actual
        $ventasPorMes = Venta::select(
            DB::raw('MONTH(fecha_venta) as mes'),
            DB::raw('SUM(total) as total_ventas')
        )
        ->whereYear('fecha_venta', date('Y'))
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

        // Top 5 productos más vendidos
        $topProductos = DB::table('ventas')
            ->select('productos->nombre as nombre', DB::raw('SUM(JSON_EXTRACT(productos, "$.cantidad")) as total_vendido'))
            ->groupBy('nombre')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get();

        // Ventas totales del día
        $ventasHoy = Venta::whereDate('fecha_venta', today())->sum('total');

        // Ventas totales del mes
        $ventasMes = Venta::whereMonth('fecha_venta', now()->month)
            ->whereYear('fecha_venta', now()->year)
            ->sum('total');

        return view('home', compact(
            'ventasPorMes',
            'topProductos',
            'ventasHoy',
            'ventasMes'
        ));
    }
}
