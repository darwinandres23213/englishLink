<?php

namespace Database\Factories;

use App\Models\Clase;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class AsistenciaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'clase_id' => Clase::inRandomOrder()->first()?->id_clase ?? 1,
            'estudiante_id' => Usuario::inRandomOrder()->first()?->id_usuario ?? 1,
            'asistio' => $this->faker->boolean,
        ];
    }
}