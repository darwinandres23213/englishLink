<?php

namespace Database\Factories;

use App\Models\Usuario;
use App\Models\Curso;
use App\Models\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistroCalificacioneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::inRandomOrder()->first()?->id_usuario ?? 1,
            'curso_id' => Curso::inRandomOrder()->first()?->id_curso ?? 1,
            'calificacion' => $this->faker->randomFloat(1, 0, 100),
            'retroalimentacion' => $this->faker->sentence,
            'fecha_registro' => $this->faker->date(),
            'pendiente_recuperacion' => $this->faker->boolean,
            'creado_por' => $this->faker->name,
            'actualizado_por' => $this->faker->name,
            'estado_id' => Estado::inRandomOrder()->first()?->id_estado ?? 1,
        ];
    }
}