<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model {

    use HasFactory;

    protected $table = 'alertas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'usuario_id',
        'hora_alerta',
        'tipo_alerta',
        'mensaje',
        'estado_id',
        'fecha_creacion',
    ];
    protected $casts = [
        'hora_alerta' => 'string', // Para time type
        'fecha_creacion' => 'datetime',
    ];


    //relaciones  
    public function usuario(){
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }
    public function estado(){
        return $this->belongsTo(Estado::class, 'estado_id', 'id_estado');
    }
}