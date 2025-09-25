<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model {
    use HasFactory;

    protected $table = 'estados';
    protected $primaryKey = 'id_estado';
    protected $fillable = [
        'id_tipo_estado',
        'nombre_estado',
    ];

    // Relación con TiposEstado
    public function tipoEstado(){
        return $this->belongsTo(TiposEstado::class, 'id_tipo_estado', 'id_tipo_estado');
    }




    // Helper general
    public static function porTipo($tipoEstado, $nombreEstado = null) {
        $query = self::whereHas('tipoEstado', function($q) use ($tipoEstado) {
            $q->where('nombre_tipo_estado', $tipoEstado);
        });
        
        return $nombreEstado ? $query->where('nombre_estado', $nombreEstado)->first() : $query->get();
    }

    // Helpers específicos para usuarios
    public static function usuarioActivo() { return self::porTipo('Usuario', 'Activo'); }
    public static function usuarioInactivo() { return self::porTipo('Usuario', 'Inactivo'); }
    public static function usuarioSuspendido() { return self::porTipo('Usuario', 'Suspendido'); }

    // Helpers específicos para pagos
    public static function pagoPendiente() { return self::porTipo('Pago', 'Pendiente'); }
    public static function pagoPagado() { return self::porTipo('Pago', 'Pagado'); }
    public static function pagoVencido() { return self::porTipo('Pago', 'Vencido'); }

    // Helpers específicos para cursos
    public static function cursoDisponible() { return self::porTipo('Curso', 'Disponible'); }
    public static function cursoEnProgreso() { return self::porTipo('Curso', 'En Progreso'); }
    public static function cursoFinalizado() { return self::porTipo('Curso', 'Finalizado'); }

    // Helpers específicos para matrículas
    public static function matriculaInscrita() { return self::porTipo('Matricula', 'Inscrito'); }
    public static function matriculaEnCurso() { return self::porTipo('Matricula', 'En Curso'); }
    public static function matriculaCompletada() { return self::porTipo('Matricula', 'Completado'); }

    // Helpers específicos para asistencias
    public static function asistenciaPresente() { return self::porTipo('Asistencia', 'Presente'); }
    public static function asistenciaAusente() { return self::porTipo('Asistencia', 'Ausente'); }
    public static function asistenciaTardanza() { return self::porTipo('Asistencia', 'Tardanza'); }

}
