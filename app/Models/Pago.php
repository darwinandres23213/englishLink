<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model {
    
    use HasFactory;

    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';

    protected $fillable = [
        'matricula_id',
        //'estudiante_id',
        'monto',
        'fecha_pago',
        'estado_pago_id',
        'medio_pago_id',
    ];



    
    // Relaciones
    public function matricula(){
        return $this->belongsTo(Matricula::class, 'matricula_id', 'id_matricula');
    }
    /*public function estudiante(){
        return $this->belongsTo(Usuario::class, 'estudiante_id', 'id_usuario');
    }*/
    public function estudiante(){
        return $this->hasOneThrough(
            Usuario::class, 
            Matricula::class, 
            'id_matricula',    // FK en matriculas que apunta a pagos
            'id_usuario',      // FK en usuarios que apunta a matriculas  
            'matricula_id',    // Local key en pagos
            'estudiante_id'    // Local key en matriculas
        );
    }
    public function estadoPago(){
        return $this->belongsTo(Estado::class, 'estado_pago_id', 'id_estado');
    }
    public function medioPago(){
        return $this->belongsTo(MediosPago::class, 'medio_pago_id', 'id_medio_pago');
    }
}