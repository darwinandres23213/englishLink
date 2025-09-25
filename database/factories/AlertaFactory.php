<?php

namespace Database\Factories;

use App\Models\Alerta;
use App\Models\Usuario;
use App\Models\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlertaFactory extends Factory
{
    protected $model = Alerta::class;

    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::inRandomOrder()->first()?->id_usuario ?? 1,
            'hora_alerta' => $this->faker->time('H:i:s'), // Solo hora según ER
            'tipo_alerta' => $this->faker->randomElement(['sistema', 'curso', 'usuario', 'urgente']),
            'mensaje' => $this->faker->sentence(10),
            'estado_id' => Estado::inRandomOrder()->first()?->id_estado ?? 1,
            'fecha_creacion' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}