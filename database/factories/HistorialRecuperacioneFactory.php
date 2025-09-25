<?php

namespace Database\Factories;

use App\Models\Recuperacione;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistorialRecuperacioneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_recuperacion' => Recuperacione::inRandomOrder()->first()?->id ?? 1,
            'nota_anterior' => $this->faker->randomFloat(1, 0, 100),
            'nota_nueva' => $this->faker->randomFloat(1, 0, 100),
            'fecha_cambio' => $this->faker->date(),
            'modificado_por' => $this->faker->name,
        ];
    }
}