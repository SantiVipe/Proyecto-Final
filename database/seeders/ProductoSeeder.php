<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use Faker\Factory as Faker;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        // Lista de nombres de productos comunes
        $nombresProductos = [
            'Laptop', 'Smartphone', 'Tablet', 'Monitor', 'Teclado', 'Mouse', 'Auriculares',
            'Impresora', 'Router', 'Cámara', 'Disco Duro', 'Memoria USB', 'Cargador',
            'Cable HDMI', 'Adaptador', 'Batería', 'Fundas', 'Soporte', 'Estuche',
            'Protector de Pantalla', 'Limpieza', 'Accesorios', 'Repuestos', 'Herramientas'
        ];

        // Rangos de precios por tipo de producto (en COP)
        $rangosPrecios = [
            'Laptop' => ['min' => 1500000, 'max' => 5000000],
            'Smartphone' => ['min' => 800000, 'max' => 3000000],
            'Tablet' => ['min' => 1000000, 'max' => 2500000],
            'Monitor' => ['min' => 500000, 'max' => 2000000],
            'Teclado' => ['min' => 50000, 'max' => 300000],
            'Mouse' => ['min' => 30000, 'max' => 200000],
            'Auriculares' => ['min' => 50000, 'max' => 500000],
            'Impresora' => ['min' => 300000, 'max' => 1500000],
            'Router' => ['min' => 100000, 'max' => 500000],
            'Cámara' => ['min' => 200000, 'max' => 2000000],
            'Disco Duro' => ['min' => 100000, 'max' => 800000],
            'Memoria USB' => ['min' => 20000, 'max' => 200000],
            'Cargador' => ['min' => 30000, 'max' => 150000],
            'Cable HDMI' => ['min' => 15000, 'max' => 100000],
            'Adaptador' => ['min' => 20000, 'max' => 150000],
            'Batería' => ['min' => 50000, 'max' => 300000],
            'Fundas' => ['min' => 20000, 'max' => 100000],
            'Soporte' => ['min' => 30000, 'max' => 200000],
            'Estuche' => ['min' => 15000, 'max' => 80000],
            'Protector de Pantalla' => ['min' => 10000, 'max' => 50000],
            'Limpieza' => ['min' => 10000, 'max' => 50000],
            'Accesorios' => ['min' => 20000, 'max' => 200000],
            'Repuestos' => ['min' => 30000, 'max' => 300000],
            'Herramientas' => ['min' => 20000, 'max' => 150000]
        ];

        // Crear 100 productos de ejemplo
        for ($i = 0; $i < 100; $i++) {
            $nombreBase = $faker->randomElement($nombresProductos);
            $marca = $faker->randomElement(['Samsung', 'Apple', 'HP', 'Dell', 'Lenovo', 'Asus', 'Acer', 'LG', 'Sony', 'Microsoft']);
            $modelo = $faker->bothify('??-###');
            
            // Obtener el rango de precios para este tipo de producto
            $rangoPrecio = $rangosPrecios[$nombreBase];
            
            Producto::create([
                'codigo' => $faker->unique()->numerify('PROD-####'),
                'nombre' => $nombreBase . ' ' . $marca . ' ' . $modelo,
                'descripcion' => $faker->paragraph(),
                'stock' => $faker->numberBetween(0, 100),
                'precio_venta' => $faker->numberBetween($rangoPrecio['min'], $rangoPrecio['max']),
            ]);
        }

        $this->command->info('100 productos generados exitosamente con precios en pesos colombianos.');
    }
} 