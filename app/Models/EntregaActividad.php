<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaActividad extends Model
{
    use HasFactory;

    protected $table = 'entregas_actividades';
    protected $primaryKey = 'id_entrega';
    
    protected $fillable = [
        'actividad_id',
        'estudiante_id',
        'respuesta_texto',
        'archivo_entrega',
        'fecha_entrega',
        'calificacion_obtenida',
        'retroalimentacion_profesor',
        'fecha_calificacion',
        'calificado_por',
        'estado'
    ];

    protected $casts = [
        'fecha_entrega' => 'datetime',
        'fecha_calificacion' => 'datetime'
    ];

    // Relaciones
    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id', 'id_actividad');
    }

    public function estudiante()
    {
        return $this->belongsTo(Usuario::class, 'estudiante_id', 'id_usuario');
    }

    public function profesorCalificador()
    {
        return $this->belongsTo(Usuario::class, 'calificado_por', 'id_usuario');
    }

    // Verificar si fue entregado a tiempo
    public function fueEntregadoATiempo()
    {
        if (!$this->fecha_entrega || !$this->actividad) {
            return false;
        }
        
        return $this->fecha_entrega <= $this->actividad->fecha_vencimiento;
    }

    // Verificar si está calificado
    public function estaCalificado()
    {
        return $this->estado === 'calificado' && !is_null($this->calificacion_obtenida);
    }

    // Obtener porcentaje de calificación
    public function porcentajeCalificacion()
    {
        if (!$this->estaCalificado() || !$this->actividad) {
            return 0;
        }
        
        return ($this->calificacion_obtenida / $this->actividad->calificacion_maxima) * 100;
    }

    // Accessor para usar 'calificacion' como alias de 'calificacion_obtenida'
    public function getCalificacionAttribute()
    {
        return $this->calificacion_obtenida;
    }
}
