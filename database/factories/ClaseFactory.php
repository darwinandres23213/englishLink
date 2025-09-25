<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClaseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'curso_id' => Curso::inRandomOrder()->first()?->id_curso ?? 1,
            'fecha' => $this->faker->date(),
            'tema' => $this->faker->sentence(3),
            'material' => $this->faker->paragraph,
        ];
    }
}