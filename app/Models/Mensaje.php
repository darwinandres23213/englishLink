<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model {
    use HasFactory;

    protected $table = 'mensajes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'remitente_id',
        'destinatario_id',
        'contenido',
        'fecha_envio',
        'leido',
        'tiene_adjuntos',
    ];

    // Relaciones
    public function remitente() {
        return $this->belongsTo(Usuario::class, 'remitente_id', 'id_usuario');
    }
    public function destinatario() {
        return $this->belongsTo(Usuario::class, 'destinatario_id', 'id_usuario');
    }
}