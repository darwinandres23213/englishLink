<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('registro_actividades', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('usuario_id');
            $table->string('accion');
            $table->timestamp('fecha_hora');
            $table->ipAddress('ip_origen');
            $table->string('modulo_afectado');
            $table->unsignedBigInteger('curso_id');
            $table->text('descripcion');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios');
            $table->foreign('curso_id')->references('id_curso')->on('cursos');
        });
    }


    public function down(): void{
        Schema::dropIfExists('registro_actividades');
    }
};
