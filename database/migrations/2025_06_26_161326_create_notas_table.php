<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('notas', function (Blueprint $table) { 
            $table->id('id_nota');
            $table->unsignedBigInteger('evaluacion_id');
            $table->unsignedBigInteger('estudiante_id');
            $table->decimal('calificacion', 5, 2);
            $table->timestamps();

            // Relaciones
            $table->foreign('evaluacion_id')->references('id_evaluacion')->on('evaluaciones');
            $table->foreign('estudiante_id')->references('id_usuario')->on('usuarios');
        });
    }

    public function down(): void {
        Schema::dropIfExists('notas');
    }
};