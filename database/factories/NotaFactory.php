<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'evaluacion_id' => $this->faker->numberBetween(1, 10),
            'estudiante_id' => $this->faker->numberBetween(1, 10),
            'calificacion' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}