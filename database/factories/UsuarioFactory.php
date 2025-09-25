<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;
use App\Models\Estado;

class UsuarioFactory extends Factory
{
    public function definition(): array{
        return [
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'contrasena' => bcrypt('password'), // Contraseña encriptada
            'rol_id' => Role::inRandomOrder()->first()?->id_rol ?? 1,
            //'estado_id' => Estado::inRandomOrder()->first()?->id_estado ?? 1,
            'estado_id' => Estado::where('nombre_estado', 'Activo')->first()?->id_estado ?? 1,
        ];
    }


    // Método específico para crear profesores
    public function profesor() {
        return $this->state(function (array $attributes) {
            $rolProfesor = Role::where('nombre_rol', 'Profesor')->first();
            return [
                'rol_id' => $rolProfesor ? $rolProfesor->id_rol : 2, // 2 es el ID del rol Profesor
            ];
        });
    }


    // Método específico para crear estudiantes
    public function estudiante() {
        return $this->state(function (array $attributes) {
            $rolEstudiante = Role::where('nombre_rol', 'Estudiante')->first();
            return [
                'rol_id' => $rolEstudiante ? $rolEstudiante->id_rol : 3, // 3 es el ID del rol Estudiante
            ];
        });
    }


    // Método específico para crear administradores
    public function administrador() {
        return $this->state(function (array $attributes) {
            $rolAdmin = Role::where('nombre_rol', 'Administrador')->first();
            return [
                'rol_id' => $rolAdmin ? $rolAdmin->id_rol : 1, // 1 es el ID del rol Administrador
            ];
        });
    }
};