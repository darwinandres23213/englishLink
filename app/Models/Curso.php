<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model{
    use HasFactory;

    protected $table = 'cursos';
    protected $primaryKey = 'id_curso';
    protected $fillable = [
        'nombre_curso',
        'descripcion',
        'nivel_id',
        'horario_id',
        'profesor_id',
    ];

    // Relaciones
    public function nivel() { 
        return $this->belongsTo(Nivele::class, 'nivel_id', 'id_nivel');
    }
    public function horario() {
        return $this->belongsTo(Horario::class, 'horario_id', 'id_horario');
    }
    public function profesor() {
        return $this->belongsTo(Usuario::class, 'profesor_id', 'id_usuario');
    }

    // Relaciones adicionales para actividades
    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'curso_id', 'id_curso');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'curso_id', 'id_curso');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Usuario::class, 'matriculas', 'curso_id', 'estudiante_id', 'id_curso', 'id_usuario');
    }

    // Verificar si un estudiante está matriculado
    public function tieneEstudiante($estudiante_id)
    {
        return $this->matriculas()->where('estudiante_id', $estudiante_id)->exists();
    }

    // Obtener actividades activas
    public function actividadesActivas()
    {
        return $this->actividades()->where('activa', true);
    }
}
