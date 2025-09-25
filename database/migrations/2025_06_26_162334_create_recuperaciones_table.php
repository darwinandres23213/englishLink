<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('recuperaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_calificacion');
            $table->decimal('nota_recuperacion', 3, 1);
            $table->unsignedBigInteger('estado_id');
            $table->date('fecha_recuperacion');
            $table->string('creado_por');
            $table->string('actualizado_por');
            $table->string('comentarios');
            $table->timestamps();

            //Relaciones
            $table->foreign('id_calificacion')->references('id')->on('registro_calificaciones');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
        });
    }

    public function down(): void {
        Schema::dropIfExists('recuperaciones');
    }
};
