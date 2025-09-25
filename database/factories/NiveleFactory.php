<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NiveleFactory extends Factory {
    public function definition(): array {
        return [
            'nombre_nivel' => $this->faker->unique()->randomElement([
                'Básico',
                'Intermedio',
                'Avanzado',
            ]),
        ];
    }
}
