<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;
use App\Models\Curso;

class MatriculaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'estudiante_id' => Usuario::inRandomOrder()->first()?->id_usuario ?? 1, // Genera un usuario aleatorio
            'curso_id' => Curso::inRandomOrder()->first()?->id_curso ?? 1, // Genera un curso aleatorio
            'fecha_matricula' => $this->faker->date(),
        ];
    }
};