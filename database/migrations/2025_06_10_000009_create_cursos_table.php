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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id('id_curso');
            $table->string('nombre_curso', 100);
            $table->string('descripcion', 255)->nullable();
            $table->unsignedBigInteger('nivel_id');
            $table->unsignedBigInteger('horario_id');
            //$table->unsignedBigInteger('estado_id');
            $table->unsignedBigInteger('profesor_id');
            $table->timestamps();

            // Relaciones
            $table->foreign('nivel_id')->references('id_nivel')->on('niveles');
            $table->foreign('horario_id')->references('id_horario')->on('horarios');
            //$table->foreign('estado_id')->references('id_estado')->on('estados');
            $table->foreign('profesor_id')->references('id_usuario')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
