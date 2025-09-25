<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id('id_horario');
            $table->string('nombre_horario', 50);
            $table->time('hora_inicio');
            $table->time('hora_fin');
            //$table->string('dias_semana', 50); // Ejemplo: "Lunes, Martes, Miércoles"
            //$table->string('ubicacion', 100)->nullable(); // Ubicación del curso, si aplica
            //$table->unsignedBigInteger('estado_id')->nullable(); // Estado del horario, si aplica

            // No tiene relaciones
            //$table->foreign('estado_id')->references('id_estado')->on('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
