<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model{
    use HasFactory;

    protected $table = 'horarios';
    protected $primaryKey = 'id_horario';

    protected $fillable = [
        'nombre_horario',
        'hora_inicio',
        'hora_fin',
    ];
}
