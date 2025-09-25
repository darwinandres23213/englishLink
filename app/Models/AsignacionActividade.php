<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Curso;
use App\Models\Estado;

class AsignacionActividade extends Model{
    use HasFactory;

    protected $table = 'asignacion_actividades';
    protected $primaryKey = 'id';
    protected $fillable = [
        'usuario_id',
        'curso_id',
        'nombre',
        'estado_id',
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    public function curso(){
        return $this->belongsTo(Curso::class, 'curso_id', 'id_curso');
    }

    public function estado(){
        return $this->belongsTo(Estado::class, 'estado_id', 'id_estado');
    }
}
