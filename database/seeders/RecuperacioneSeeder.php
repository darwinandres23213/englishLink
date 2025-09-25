<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recuperacione;

class RecuperacioneSeeder extends Seeder
{
    public function run(): void
    {
        Recuperacione::factory()->count(20)->create();
    }
}