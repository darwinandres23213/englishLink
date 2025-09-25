<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clase;

class ClaseSeeder extends Seeder
{
    public function run(): void
    {
        Clase::factory()->count(10)->create();
    }
}