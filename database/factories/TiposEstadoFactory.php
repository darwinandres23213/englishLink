<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TiposEstado>
 */
class TiposEstadoFactory extends Factory{
    public function definition(): array{
        return [
        'nombre_tipo_estado' => $this->faker->randomElement(['General', 'Especial', 'Temporal']),
        ];
    }
}
