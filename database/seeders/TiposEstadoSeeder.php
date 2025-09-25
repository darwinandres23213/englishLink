<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TiposEstado;

class TiposEstadoSeeder extends Seeder {
    public function run(): void {
        //TiposEstado::factory()->count(10)->create();

        $tiposEstado = [
            ['nombre_tipo_estado' => 'Usuario'],
            ['nombre_tipo_estado' => 'Curso'], 
            ['nombre_tipo_estado' => 'Matricula'],
            ['nombre_tipo_estado' => 'Pago'],
            ['nombre_tipo_estado' => 'Actividad'],
            ['nombre_tipo_estado' => 'Asistencia'],
            ['nombre_tipo_estado' => 'Alerta'],
            ['nombre_tipo_estado' => 'MedioPago'],
            ['nombre_tipo_estado' => 'General'],
        ];
        foreach ($tiposEstado as $tipo) {
            TiposEstado::create($tipo);
        }
    }
}
