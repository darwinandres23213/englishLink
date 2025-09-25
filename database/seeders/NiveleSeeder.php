<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nivele;

class NiveleSeeder extends Seeder{
    public function run(): void{
        $niveles = [
            ['nombre_nivel' => 'Básico'],
            ['nombre_nivel' => 'Intermedio'], 
            ['nombre_nivel' => 'Avanzado'],
        ];

        foreach ($niveles as $nivel) {
            // Crear solo si no existe para evitar duplicados
            Nivele::firstOrCreate([
                'nombre_nivel' => $nivel['nombre_nivel']
            ]);
        }
    }
}