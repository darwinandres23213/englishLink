<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;
use App\Models\Curso;

class RegistroActividadeFactory extends Factory{
    public function definition(): array{
        return [
            'usuario_id' => Usuario::inRandomOrder()->first()?->id_usuario ?? 1,
            'accion' => $this->faker->word(),
            'fecha_hora' => $this->faker->dateTime(),
            'ip_origen' => $this->faker->ipv4(),
            'modulo_afectado' => $this->faker->word(),
            'curso_id' => Curso::inRandomOrder()->first()?->id_curso ?? 1,
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
