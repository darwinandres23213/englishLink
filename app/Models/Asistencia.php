<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model {
    use HasFactory;

    protected $table = 'asistencias';
    protected $primaryKey = 'id_asistencia';

    protected $fillable = [
        'clase_id',
        'estudiante_id',
        'estado_id',
    ];

    public function clase()
    {
        return $this->belongsTo(Clase::class, 'clase_id', 'id_clase');
    }

    public function estudiante()
    {
        return $this->belongsTo(Usuario::class, 'estudiante_id', 'id_usuario');
    }
    
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id', 'id_estado');
    }
}