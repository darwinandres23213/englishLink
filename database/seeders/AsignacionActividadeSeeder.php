<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AsignacionActividade;

class AsignacionActividadeSeeder extends Seeder{
    public function run(): void{
        AsignacionActividade::factory()->count(100)->create();
    }
}