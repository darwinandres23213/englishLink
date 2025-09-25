<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Curso;

class Matricula extends Model{
    use HasFactory;

    protected $table = 'matriculas';
    protected $primaryKey = 'id_matricula';
    protected $fillable = [
        'estudiante_id',
        'curso_id',
        'fecha_matricula',
    ];

    // Relación con estudiante (usuario)
    public function estudiante(){
        return $this->belongsTo(Usuario::class, 'estudiante_id', 'id_usuario');
    }

    // Relación con curso
    public function curso(){
        return $this->belongsTo(Curso::class, 'curso_id', 'id_curso');
    }
}
