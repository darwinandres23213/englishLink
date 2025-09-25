<?php

namespace Database\Factories;

use App\Models\RegistroCalificacione;
use App\Models\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecuperacioneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_calificacion' => RegistroCalificacione::inRandomOrder()->first()?->id ?? 1,
            'nota_recuperacion' => $this->faker->randomFloat(1, 0, 100),
            'estado_id' => Estado::inRandomOrder()->first()?->id_estado ?? 1,
            'fecha_recuperacion' => $this->faker->date(),
            'creado_por' => $this->faker->name,
            'actualizado_por' => $this->faker->name,
            'comentarios' => $this->faker->sentence,
        ];
    }
}