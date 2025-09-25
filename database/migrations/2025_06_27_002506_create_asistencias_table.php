<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id('id_asistencia');
            $table->unsignedBigInteger('clase_id');
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('estado_id'); // Usar estado_id en lugar de asistio
            $table->timestamps();
            
            $table->foreign('clase_id')->references('id_clase')->on('clases');
            $table->foreign('estudiante_id')->references('id_usuario')->on('usuarios');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
        });
    }

    public function down(): void {
        Schema::dropIfExists('asistencias');
    }
};
