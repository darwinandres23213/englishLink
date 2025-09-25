<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recuperacione extends Model
{
    use HasFactory;

    protected $table = 'recuperaciones';

    protected $fillable = [
        'id_calificacion',
        'nota_recuperacion',
        'estado_id',
        'fecha_recuperacion',
        'creado_por',
        'actualizado_por',
        'comentarios',
    ];

    public function registroCalificacion()
    {
        return $this->belongsTo(RegistroCalificacione::class, 'id_calificacion', 'id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id', 'id_estado');
    }
}