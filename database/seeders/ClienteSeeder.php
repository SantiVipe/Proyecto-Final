<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use Faker\Factory as Faker;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        // Crear 200 clientes de ejemplo
        for ($i = 0; $i < 200; $i++) {
            Cliente::create([
                'nombre' => $faker->name(),
                'cedula' => $faker->unique()->numerify('##########'), // Genera un número de 10 dígitos
                'direccion' => $faker->address(),
                'telefono' => $faker->numerify('###########'), // Genera un número de 11 dígitos
            ]);
        }

        $this->command->info('200 clientes generados exitosamente.');
    }
} 