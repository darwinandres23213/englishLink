<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asistencia;

class AsistenciaSeeder extends Seeder
{
    public function run(): void
    {
        Asistencia::factory()->count(20)->create();
    }
}