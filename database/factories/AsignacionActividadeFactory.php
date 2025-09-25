<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;
use App\Models\Curso;
use App\Models\Estado;

class AsignacionActividadeFactory extends Factory{
    public function definition(): array{
        return [
            'usuario_id' => Usuario::inRandomOrder()->first()?->id_usuario ?? 1,
            'curso_id' => Curso::inRandomOrder()->first()?->id_curso ?? 1,
            'nombre' => $this->faker->sentence(3),
            'estado_id' => Estado::inRandomOrder()->first()?->id_estado ?? 1,
        ];
    }
}
