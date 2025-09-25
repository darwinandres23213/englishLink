<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder {
    public function run(): void {
        //Usuario::factory()->count(50)->create();

        // Usuario::factory()->administrador()->count(2)->create();
        // Usuario::factory()->profesor()->count(15)->create();
        // Usuario::factory()->estudiante()->count(30)->create();




        // Usuarios de prueba
        Usuario::create([
            'nombre' => 'Richi',
            'apellido' => 'Rey',
            'email' => 'rich44@gmail.com',
            'contrasena' => bcrypt('rich123+'),
            'rol_id' => 1, // Administrador
            'estado_id' => 1,
        ]);

        Usuario::create([
            'nombre' => 'Camilo',
            'apellido' => 'Valencia',
            'email' => 'teachersvl@hotmail.com',
            'contrasena' => bcrypt('camilo456+'),
            'rol_id' => 2, // Profesor
            'estado_id' => 1,
        ]);

        Usuario::create([
            'nombre' => 'Lionel',
            'apellido' => 'Vargas',
            'email' => 'r.studentvl@hotmail.com',
            'contrasena' => bcrypt('lionel789+'),
            'rol_id' => 3, // Estudiante
            'estado_id' => 1,
        ]);

        Usuario::create([
            'nombre' => 'Danna',
            'apellido' => 'Castro',
            'email' => 'danna@gmail.com',
            'contrasena' => bcrypt('danna123+'),
            'rol_id' => 3, // Estudiante
            'estado_id' => 1,
        ]);

    }
};