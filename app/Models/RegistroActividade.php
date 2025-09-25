<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroActividade extends Model{
    use HasFactory;

    protected $table = 'registro_actividades';
    protected $primaryKey = 'id';
    protected $fillable = [
        'usuario_id',
        'accion',
        'fecha_hora',
        'ip_origen',
        'modulo_afectado',
        'curso_id',
        'descripcion',
    ];


    // Relaciones
    public function usuario(){
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    public function curso(){
        return $this->belongsTo(Curso::class, 'curso_id', 'id_curso');
    }
}