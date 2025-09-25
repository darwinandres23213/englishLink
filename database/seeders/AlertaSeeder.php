<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alerta;
use App\Models\Usuario;
use App\Models\Estado;

class AlertaSeeder extends Seeder{

    public function run(): void{
        //Alerta::factory()->count(100)->create();

        
        // Verificar que existan usuarios y estados según las relaciones del ER
        if (Usuario::count() > 0 && Estado::count() > 0) {
            Alerta::factory()->count(100)->create();
        } else {
            $this->command->warn('Faltan datos relacionados: usuarios o estados');
        }
    }
}