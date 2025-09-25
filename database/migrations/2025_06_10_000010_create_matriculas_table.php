<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id('id_matricula');
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('curso_id');
            /*$table->unsignedBigInteger('estado_matricula_id');*/
            $table->date('fecha_matricula');
            $table->timestamps();

            /*Relaciones*/
            $table->foreign('estudiante_id')->references('id_usuario')->on('usuarios');
            $table->foreign('curso_id')->references('id_curso')->on('cursos');
            /*$table->foreign('estado_matricula_id')->references('id_estado')->on('estados');*/
        });
    }

    public function down(): void{
        Schema::dropIfExists('matriculas');
    }
};
