<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialRecuperacione extends Model
{
    use HasFactory;

    protected $table = 'historial_recuperaciones';

    protected $fillable = [
        'id_recuperacion',
        'nota_anterior',
        'nota_nueva',
        'fecha_cambio',
        'modificado_por',
    ];

    public function recuperacion()
    {
        return $this->belongsTo(Recuperacione::class, 'id_recuperacion', 'id');
    }
}