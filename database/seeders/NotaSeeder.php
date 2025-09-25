<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nota;

class NotaSeeder extends Seeder {
    
    public function run(): void {
        Nota::factory()->count(20)->create();
    }
}
