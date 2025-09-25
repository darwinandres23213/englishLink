<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('remitente_id');
            $table->unsignedBigInteger('destinatario_id');
            $table->text('contenido');
            $table->dateTime('fecha_envio'); //timestamp
            $table->unsignedBigInteger('estado_id');
            $table->tinyInteger('tiene_adjuntos')->default(0); // Campo faltante
            $table->timestamps();

            // Relaciones
            $table->foreign('remitente_id')->references('id_usuario')->on('usuarios');
            $table->foreign('destinatario_id')->references('id_usuario')->on('usuarios');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
        });
    }

    public function down(): void {
        Schema::dropIfExists('mensajes');
    }
};