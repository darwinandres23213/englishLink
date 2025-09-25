<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mensaje;
use App\Models\Usuario;

class MensajeSeeder extends Seeder {
    
    public function run(): void {
        if (Usuario::count() > 1) {
            Mensaje::factory()->count(50)->create();
        } else {
            $this->command->warn('No hay suficientes usuarios para crear mensajes.');
        }
    }
}

