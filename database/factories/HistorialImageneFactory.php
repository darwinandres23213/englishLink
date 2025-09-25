<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;

class HistorialImageneFactory extends Factory{
    public function definition(): array{
        return [
            'usuario_id' => Usuario::inRandomOrder()->first()?->id_usuario ?? 1,
            'nombre_imagen' => $this->faker->imageUrl(),
            'fecha_subida' => $this->faker->dateTimeThisYear(),
        ];
    }
}
