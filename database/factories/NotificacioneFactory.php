<?php

namespace Database\Factories;

use App\Models\Usuario;
use App\Models\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificacioneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::inRandomOrder()->first()?->id_usuario ?? 1,
            'mensaje' => $this->faker->sentence(10),
            'estado_id' => Estado::inRandomOrder()->first()?->id_estado ?? 1,
            'tipo' => $this->faker->randomElement(['Sistema', 'Curso', 'Usuario']),
            'fecha_envio' => $this->faker->dateTime(),
        ];
    }
}