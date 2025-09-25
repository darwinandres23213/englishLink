<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';
    protected $primaryKey = 'id_actividad';
    
    // Especifica qué campo usar para el route model binding
    public function getRouteKeyName()
    {
        return 'id_actividad';
    }
    
    protected $fillable = [
        'curso_id',
        'profesor_id',
        'titulo',
        'descripcion',
        'instrucciones',
        'fecha_asignacion',
        'fecha_vencimiento',
        'calificacion_maxima',
        'tipo_entrega',
        'activa'
    ];

    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'fecha_vencimiento' => 'datetime',
        'calificacion_maxima' => 'decimal:2',
        'activa' => 'boolean'
    ];

    // Relaciones
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id', 'id_curso');
    }

    public function profesor()
    {
        return $this->belongsTo(Usuario::class, 'profesor_id', 'id_usuario');
    }

    public function entregas()
    {
        return $this->hasMany(EntregaActividad::class, 'actividad_id', 'id_actividad');
    }

    // Obtener estudiantes del curso que tienen esta actividad
    public function estudiantesDelCurso()
    {
        return Usuario::whereHas('matriculas', function($query) {
            $query->where('curso_id', $this->curso_id);
        })->whereHas('rol', function($query) {
            $query->where('nombre_rol', 'Estudiante');
        });
    }

    // Verificar si está vencida
    public function estaVencida()
    {
        return now() > $this->fecha_vencimiento;
    }

    // Obtener entrega de un estudiante específico
    public function entregaDeEstudiante($estudiante_id)
    {
        return $this->entregas()->where('estudiante_id', $estudiante_id)->first();
    }
}
