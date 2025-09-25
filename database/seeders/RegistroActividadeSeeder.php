<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RegistroActividade;

class RegistroActividadeSeeder extends Seeder{
    public function run(): void{
        RegistroActividade::factory()->count(50)->create();
    }
}
