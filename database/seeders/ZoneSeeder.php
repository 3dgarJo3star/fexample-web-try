<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            ['name' => 'Monterrey Centro', 'description' => 'Área metropolitana de Monterrey'],
            ['name' => 'Ciénega de Flores', 'description' => 'Municipio de Ciénega de Flores'],
            ['name' => 'La Estanzuela', 'description' => 'Zona La Estanzuela, Monterrey'],
            ['name' => 'Santa Catarina', 'description' => 'Municipio de Santa Catarina'],
            ['name' => 'Villa García', 'description' => 'Municipio de Villa García'],
            ['name' => 'García', 'description' => 'Municipio de García, Nuevo León'],
            ['name' => 'Apodaca', 'description' => 'Municipio de Apodaca'],
            ['name' => 'San Nicolás', 'description' => 'Municipio de San Nicolás de los Garza'],
            ['name' => 'Guadalupe', 'description' => 'Municipio de Guadalupe'],
            ['name' => 'San Pedro Garza García', 'description' => 'Municipio de San Pedro Garza García'],
            ['name' => 'Escobedo', 'description' => 'General Escobedo'],
            ['name' => 'Juárez', 'description' => 'Municipio de Juárez, N.L.'],
        ];

        foreach ($zones as $zone) {
            Zone::firstOrCreate(['name' => $zone['name']], $zone);
        }
    }
}
