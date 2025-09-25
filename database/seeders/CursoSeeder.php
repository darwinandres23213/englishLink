<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso; //IMPORTANTE: Asegúrate de que el modelo Curso exista en tu aplicación
use App\Models\Role;
use App\Models\Usuario;

class CursoSeeder extends Seeder {
    public function run(): void {
        // Verificar que existan profesores antes de crear cursos
        $rolProfesor = Role::where('nombre_rol', 'Profesor')->first();
        
        if ($rolProfesor) {
            $profesoresCount = Usuario::where('rol_id', $rolProfesor->id_rol)->count();
            
            if ($profesoresCount > 0) {
                Curso::factory()->count(20)->create();
            } else {
                $this->command->warn('No hay profesores disponibles para crear cursos');
            }
        } else {
            $this->command->warn('No existe el rol Profesor');
        }
    }
}
