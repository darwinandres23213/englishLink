<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estado>
 */
class EstadoFactory extends Factory{
    public function definition(): array{
        return [
            'id_tipo_estado' => 1,
            'nombre_estado' => $this->faker->randomElement(['Activo', 'Inactivo', 'Pendiente']),
        ];
    }
};
