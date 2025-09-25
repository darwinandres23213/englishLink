<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Evaluacione extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';
    protected $primaryKey = 'id_evaluacion';

    protected $fillable = [
        'curso_id',
        'titulo',
        // 'fecha', // si decides usarlo
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id', 'id_curso');
    }
}