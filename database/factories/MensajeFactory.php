<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;

class MensajeFactory extends Factory {
    public function definition(): array {
        $remitente = Usuario::inRandomOrder()->first();
        $destinatario = Usuario::inRandomOrder()->first();

        return [
            'remitente_id' => $remitente ? $remitente->id_usuario : 1,
            'destinatario_id' => $destinatario ? $destinatario->id_usuario : 1,
            'contenido' => $this->faker->sentence(10),
            'fecha_envio' => $this->faker->dateTime(),
            'leido' => $this->faker->boolean(),
            'tiene_adjuntos' => $this->faker->boolean(),
        ];
    }
}
