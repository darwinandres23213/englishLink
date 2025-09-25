<?php

namespace Database\Seeders;

use App\Models\Estado;
use App\Models\Nivele;
use App\Models\TiposEstado;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    
    public function run(): void {

        $this->call([
            TiposEstadoSeeder::class,
            EstadoSeeder::class,
            RoleSeeder::class,

            UsuarioSeeder::class,
            HorarioSeeder::class,
            NiveleSeeder::class,
            
            CursoSeeder::class,
            MatriculaSeeder::class,
            MediosPagoSeeder::class,
            PagoSeeder::class,
            AsignacionActividadeSeeder::class,
            HistorialImageneSeeder::class,
            RegistroActividadeSeeder::class,
            AlertaSeeder::class,
        ]);
    }
}
