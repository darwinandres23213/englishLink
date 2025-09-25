<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario; // IMPORTANTE: Asegúrate de que la ruta del modelo sea correcta

class HorarioSeeder extends Seeder{
    public function run(): void{
        Horario::factory()->count(4)->create();
    }
}
