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
        Schema::create('asignacion_actividades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('curso_id');
            $table->string('nombre', 255);
            $table->unsignedBigInteger('estado_id');
            $table->timestamps();

            //Relaciones
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios');
            $table->foreign('curso_id')->references('id_curso')->on('cursos');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_actividades');
    }
};
