<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('clases', function (Blueprint $table) {
            $table->id('id_clase');
            $table->unsignedBigInteger('curso_id');
            $table->date('fecha');
            $table->string('tema', 255);
            $table->text('material');
            $table->timestamps();

            // Relaciones
            $table->foreign('curso_id')->references('id_curso')->on('cursos');
        });
    }

    public function down(): void {
        Schema::dropIfExists('clases');
    }
};