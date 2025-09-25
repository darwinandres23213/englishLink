<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entregas_actividades', function (Blueprint $table) {
            $table->id('id_entrega');
            $table->unsignedBigInteger('actividad_id');
            $table->unsignedBigInteger('estudiante_id');
            $table->text('respuesta_texto')->nullable();
            $table->string('archivo_entrega')->nullable(); // Ruta del archivo
            $table->timestamp('fecha_entrega')->nullable();
            $table->decimal('calificacion_obtenida', 3, 1)->nullable();
            $table->text('retroalimentacion_profesor')->nullable();
            $table->timestamp('fecha_calificacion')->nullable();
            $table->unsignedBigInteger('calificado_por')->nullable(); // ID del profesor
            $table->enum('estado', ['sin_entregar', 'entregado', 'calificado', 'tardio'])->default('sin_entregar');
            $table->timestamps();

            // Relaciones
            $table->foreign('actividad_id')->references('id_actividad')->on('actividades');
            $table->foreign('estudiante_id')->references('id_usuario')->on('usuarios');
            $table->foreign('calificado_por')->references('id_usuario')->on('usuarios');
            
            // Un estudiante puede tener solo una entrega por actividad
            $table->unique(['actividad_id', 'estudiante_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entregas_actividades');
    }
};
