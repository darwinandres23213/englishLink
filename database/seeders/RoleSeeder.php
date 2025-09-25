<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder{
    public function run(): void {
        $roles = ['Administrador', 'Profesor', 'Estudiante'];
        foreach ($roles as $nombre) {
            Role::firstOrCreate(['nombre_rol' => $nombre]);
        }
        /*Role::factory()->count(5)->create();*/
    }
};