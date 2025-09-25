<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pago;
use App\Models\Matricula;
use App\Models\Estado;
use App\Models\MediosPago;

class PagoSeeder extends Seeder {
    public function run(): void {
        // Verificar que existan las dependencias antes de crear pagos
        if (Matricula::count() > 0 && Estado::count() > 0 && MediosPago::count() > 0) {
            Pago::factory()->count(100)->create();
        } else {
            $this->command->warn('No se pueden crear pagos: faltan matrículas, estados o medios de pago');
        }
    }
}