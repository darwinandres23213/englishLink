<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id('id_evaluacion');
            $table->unsignedBigInteger('curso_id');
            $table->string('titulo', 255);
            //$table->date('fecha');
            $table->timestamps();

            // Relaciones
            $table->foreign('curso_id')->references('id_curso')->on('cursos');
        });
    }

    public function down(): void {
        Schema::dropIfExists('evaluaciones');
    }
};