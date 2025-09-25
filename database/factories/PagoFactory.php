<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Matricula;
//use App\Models\Usuario;
use App\Models\Estado;
use App\Models\MediosPago;

class PagoFactory extends Factory{
    public function definition(): array
    {
        return [
            'matricula_id' => Matricula::inRandomOrder()->first()?->id_matricula ?? 1, // Asumiendo que hay al menos una matrícula
            //'estudiante_id' => Usuario::inRandomOrder()->first()?->id_usuario ?? 1,
            'monto' => $this->faker->randomFloat(2, 100, 1000),
            'fecha_pago' => $this->faker->date(),
            'medio_pago_id' => MediosPago::inRandomOrder()->first()?->id_medio_pago ?? 1, // Asumiendo que hay al menos un medio de pago
            'estado_pago_id' => Estado::whereHas('tipoEstado', function($q) {
                $q->where('nombre_tipo_estado', 'Pago');
            })->inRandomOrder()->first()?->id_estado ?? 1,
        ];
    }
}