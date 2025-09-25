<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposEstado extends Model{
    use HasFactory;

    protected $table = 'tipos_estados';
    protected $primaryKey = 'id_tipo_estado';
    protected $fillable = [
        'nombre_tipo_estado',
    ];

    // Definir qué campo usar para el route model binding
    public function getRouteKeyName() {
        return 'id_tipo_estado';
    }

    // Relacion con Estados
    public function estados(){
        return $this->hasMany(Estado::class, 'id_tipo_estado', 'id_tipo_estado');
    }
}