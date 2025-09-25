<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estado;
use App\Models\TiposEstado;

class EstadoSeeder extends Seeder {
    public function run(): void {
        //Estado::factory()->count(3)->create();

        // Obtener los IDs de tipos de estado
        $tipoUsuario = TiposEstado::where('nombre_tipo_estado', 'Usuario')->first()->id_tipo_estado;
        $tipoCurso = TiposEstado::where('nombre_tipo_estado', 'Curso')->first()->id_tipo_estado;
        $tipoMatricula = TiposEstado::where('nombre_tipo_estado', 'Matricula')->first()->id_tipo_estado;
        $tipoPago = TiposEstado::where('nombre_tipo_estado', 'Pago')->first()->id_tipo_estado;
        $tipoActividad = TiposEstado::where('nombre_tipo_estado', 'Actividad')->first()->id_tipo_estado;
        $tipoAsistencia = TiposEstado::where('nombre_tipo_estado', 'Asistencia')->first()->id_tipo_estado;
        $tipoAlerta = TiposEstado::where('nombre_tipo_estado', 'Alerta')->first()->id_tipo_estado;
        $tipoGeneral = TiposEstado::where('nombre_tipo_estado', 'General')->first()->id_tipo_estado;
        $tipoMedioPago = TiposEstado::where('nombre_tipo_estado', 'MedioPago')->first()->id_tipo_estado;

        $estados = [
            // Estados de Usuario
            ['id_tipo_estado' => $tipoUsuario, 'nombre_estado' => 'Activo'],
            ['id_tipo_estado' => $tipoUsuario, 'nombre_estado' => 'Inactivo'],
            ['id_tipo_estado' => $tipoUsuario, 'nombre_estado' => 'Suspendido'],
            ['id_tipo_estado' => $tipoUsuario, 'nombre_estado' => 'Pendiente'],

            // Estados de Curso
            ['id_tipo_estado' => $tipoCurso, 'nombre_estado' => 'Disponible'],
            ['id_tipo_estado' => $tipoCurso, 'nombre_estado' => 'En Progreso'],
            ['id_tipo_estado' => $tipoCurso, 'nombre_estado' => 'Finalizado'],
            ['id_tipo_estado' => $tipoCurso, 'nombre_estado' => 'Cancelado'],

            // Estados de Matrícula
            ['id_tipo_estado' => $tipoMatricula, 'nombre_estado' => 'Inscrito'],
            ['id_tipo_estado' => $tipoMatricula, 'nombre_estado' => 'En Curso'],
            ['id_tipo_estado' => $tipoMatricula, 'nombre_estado' => 'Completado'],
            ['id_tipo_estado' => $tipoMatricula, 'nombre_estado' => 'Retirado'],

            // Estados de Pago
            ['id_tipo_estado' => $tipoPago, 'nombre_estado' => 'Pendiente'],
            ['id_tipo_estado' => $tipoPago, 'nombre_estado' => 'Pagado'],
            ['id_tipo_estado' => $tipoPago, 'nombre_estado' => 'Vencido'],
            ['id_tipo_estado' => $tipoPago, 'nombre_estado' => 'Cancelado'],

            // Estados de Actividad
            ['id_tipo_estado' => $tipoActividad, 'nombre_estado' => 'Asignada'],
            ['id_tipo_estado' => $tipoActividad, 'nombre_estado' => 'En Progreso'],
            ['id_tipo_estado' => $tipoActividad, 'nombre_estado' => 'Completada'],
            ['id_tipo_estado' => $tipoActividad, 'nombre_estado' => 'Vencida'],

            // Estados de Asistencia
            ['id_tipo_estado' => $tipoAsistencia, 'nombre_estado' => 'Asistió'],
            ['id_tipo_estado' => $tipoAsistencia, 'nombre_estado' => 'No Asistió'],
            ['id_tipo_estado' => $tipoAsistencia, 'nombre_estado' => 'Llegó Tarde'],
            ['id_tipo_estado' => $tipoAsistencia, 'nombre_estado' => 'Falta Justificada'],

            // Estados de Alerta
            ['id_tipo_estado' => $tipoAlerta, 'nombre_estado' => 'Nueva'],
            ['id_tipo_estado' => $tipoAlerta, 'nombre_estado' => 'Leída'],
            ['id_tipo_estado' => $tipoAlerta, 'nombre_estado' => 'Archivada'],

            // Estados de Medio de Pago
            ['id_tipo_estado' => $tipoMedioPago, 'nombre_estado' => 'Activo'],
            ['id_tipo_estado' => $tipoMedioPago, 'nombre_estado' => 'Inactivo'],
            
            // Estados Generales
            ['id_tipo_estado' => $tipoGeneral, 'nombre_estado' => 'Activo'],
            ['id_tipo_estado' => $tipoGeneral, 'nombre_estado' => 'Inactivo'],
        ];

        foreach ($estados as $estado) {
            Estado::create($estado);
        }
    }
};