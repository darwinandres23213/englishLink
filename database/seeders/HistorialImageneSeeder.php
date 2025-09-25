<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HistorialImagene;

class HistorialImageneSeeder extends Seeder{
    public function run(): void{
        HistorialImagene::factory()->count(4)->create();
    }
}
