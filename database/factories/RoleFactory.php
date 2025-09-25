<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory{
    public function definition(): array{
        return [
            'nombre_rol' => $this->faker->unique()->randomElement([
                'Administrador',
                'Profesor',
                'Estudiante',
                //'Asistente',
                //'Coordinador',
                //'Secretario',
                //'Moderador',
                //'Editor',
                //'Invitado',
            ]),
        ];
    }
};