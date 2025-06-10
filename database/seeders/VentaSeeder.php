<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class VentaSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los clientes, productos y usuarios
        $clientes = Cliente::all();
        $productos = Producto::all();
        $usuarios = User::all();

        if ($clientes->isEmpty() || $productos->isEmpty() || $usuarios->isEmpty()) {
            $this->command->error('Necesitas tener clientes, productos y usuarios en la base de datos primero.');
            return;
        }

        // Generar ventas para los últimos 3 años
        $fechaFin = Carbon::now();
        $fechaInicio = Carbon::now()->subYears(3);

        // Generar ventas mes por mes
        $fechaActual = $fechaInicio->copy();
        
        while ($fechaActual <= $fechaFin) {
            // Generar entre 10 y 20 ventas por mes
            $ventasPorMes = rand(10, 20);
            
            for ($i = 0; $i < $ventasPorMes; $i++) {
                // Seleccionar cliente y usuario aleatorios
                $cliente = $clientes->random();
                $usuario = $usuarios->random();
                
                // Generar fecha aleatoria dentro del mes actual
                $fechaVenta = $fechaActual->copy()
                    ->addDays(rand(0, $fechaActual->daysInMonth - 1))
                    ->setHour(rand(8, 20))
                    ->setMinute(rand(0, 59))
                    ->setSecond(rand(0, 59));
                
                // Generar productos aleatorios para la venta (entre 1 y 5 productos)
                $productosVenta = [];
                $total = 0;
                $numProductos = rand(1, 5);
                
                for ($j = 0; $j < $numProductos; $j++) {
                    $producto = $productos->random();
                    $cantidad = rand(1, 5);
                    $precioUnitario = $producto->precio_venta;
                    $subtotal = $cantidad * $precioUnitario;
                    
                    $productosVenta[] = [
                        'producto_id' => $producto->id,
                        'nombre' => $producto->nombre,
                        'precio_unitario' => $precioUnitario,
                        'cantidad' => $cantidad,
                        'subtotal' => $subtotal
                    ];
                    
                    $total += $subtotal;
                }
                
                // Crear la venta con timestamps personalizados
                $venta = new Venta([
                    'consecutivo' => Str::uuid(),
                    'cliente_id' => $cliente->id,
                    'usuario_id' => $usuario->id,
                    'productos' => $productosVenta,
                    'fecha_venta' => $fechaVenta,
                    'total' => $total,
                    'fecha_fin_garantia' => $fechaVenta->copy()->addYears(2)
                ]);
                
                // Establecer los timestamps manualmente
                $venta->created_at = $fechaVenta;
                $venta->updated_at = $fechaVenta;
                $venta->save();
            }
            
            // Avanzar al siguiente mes
            $fechaActual->addMonth();
        }

        $this->command->info('Ventas generadas exitosamente.');
    }
} 