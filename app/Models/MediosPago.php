<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediosPago extends Model {
    use HasFactory;

    protected $table = 'medios_pagos';
    protected $primaryKey = 'id_medio_pago';
    //public $incrementing = true;
    //protected $keyType = 'int';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado_id',
    ];


    //Relaciones
    public function estado() {
        return $this->belongsTo(Estado::class, 'estado_id', 'id_estado');
    }

    // Scopes
    public function scopeActivos($query) {
        return $query->whereHas('estado', function($q) {
            $q->where('nombre_estado', 'Activo');
        });
    }

    // Helper para verificar si está activo
    public function isActivo() {
        return $this->estado && $this->estado->nombre_estado === 'Activo';
    }


    // NOTA:
    //Scope: "Dame solo los medios activos de la base de datos"
    //Helper: "¿Este medio específico está activo?"
}
