<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $table = 'clases';
    protected $primaryKey = 'id_clase';

    protected $fillable = [
        'curso_id',
        'fecha',
        'tema',
        'material',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id', 'id_curso');
    }
}