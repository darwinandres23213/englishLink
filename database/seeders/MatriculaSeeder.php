<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matricula;

class MatriculaSeeder extends Seeder
{
    public function run(): void
    {
        Matricula::factory()->count(50)->create();
    }
};