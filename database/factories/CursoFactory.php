<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Nivele;
use App\Models\Usuario;
use App\Models\Role;
use App\Models\Horario;

class CursoFactory extends Factory{
    public function definition(): array{
        // Obtener solo usuarios que son profesores
        $rolProfesor = Role::where('nombre_rol', 'Profesor')->first();
        $profesorId = 1; // Valor por defecto
        
        if ($rolProfesor) {
            $profesor = Usuario::where('rol_id', $rolProfesor->id_rol)->inRandomOrder()->first();
            $profesorId = $profesor ? $profesor->id_usuario : 1;
        }

        return [
            'nombre_curso' => $this->faker->words(2, true), // Genera nombres más realistas
            'descripcion' => $this->faker->sentence(),
            'nivel_id' => Nivele::inRandomOrder()->first()?->id_nivel ?? 1,
            'profesor_id' => $profesorId, // ✅ CORREGIDO: Solo profesores
            'horario_id' => Horario::inRandomOrder()->first()?->id_horario ?? 1,
        ];
    }
}
