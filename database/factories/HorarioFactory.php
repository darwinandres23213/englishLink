<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HorarioFactory extends Factory{
    public function definition(): array{
        return [
            'nombre_horario' => $this->faker->randomElement([
                'Mañana',
                'Tarde',
                'Noche',
                'Fin de Semana',
            ]),
            'hora_inicio' => $this->faker->time(),
            'hora_fin' => $this->faker->time(),
        ];
    }
}
