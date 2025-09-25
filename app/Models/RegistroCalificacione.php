<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCalificacione extends Model
{
    use HasFactory;

    protected $table = 'registro_calificaciones';

    protected $fillable = [
        'usuario_id',
        'curso_id',
        'calificacion',
        'retroalimentacion',
        'fecha_registro',
        'pendiente_recuperacion',
        'creado_por',
        'actualizado_por',
        'estado_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id', 'id_curso');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id', 'id_estado');
    }
}