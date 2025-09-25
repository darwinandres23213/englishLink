<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RegistroCalificacione;

class RegistroCalificacioneSeeder extends Seeder
{
    public function run(): void
    {
        RegistroCalificacione::factory()->count(20)->create();
    }
}