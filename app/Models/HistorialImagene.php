<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialImagene extends Model{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'nombre_imagen', // <--- Se actualizo (Mie 02 Julio 2025 11:54am)
        'fecha_subida',
    ];
}