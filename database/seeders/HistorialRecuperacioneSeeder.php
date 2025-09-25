<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HistorialRecuperacione;

class HistorialRecuperacioneSeeder extends Seeder
{
    public function run(): void
    {
        HistorialRecuperacione::factory()->count(20)->create();
    }
}