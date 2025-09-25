<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('registro_calificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('curso_id');
            $table->decimal('calificacion', 3, 1);
            $table->text('retroalimentacion')->nullable();
            $table->timestamp('fecha_registro');
            $table->tinyInteger('pendiente_recuperacion')->default(0);
            $table->string('creado_por');
            $table->string('actualizado_por');
            $table->unsignedBigInteger('estado_id');
            $table->timestamps();
            
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios');
            $table->foreign('curso_id')->references('id_curso')->on('cursos');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
        });
    }

    public function down(): void {
        Schema::dropIfExists('registro_calificaciones');
    }
};
