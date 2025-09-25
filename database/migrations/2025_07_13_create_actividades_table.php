<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id('id_actividad');
            $table->unsignedBigInteger('curso_id');
            $table->unsignedBigInteger('profesor_id'); // Quien crea la actividad
            $table->string('titulo', 255);
            $table->text('descripcion');
            $table->text('instrucciones')->nullable();
            $table->date('fecha_asignacion');
            $table->timestamp('fecha_vencimiento');
            $table->decimal('calificacion_maxima', 3, 1)->default(20.0);
            $table->enum('tipo_entrega', ['archivo', 'texto', 'ambos'])->default('archivo');
            $table->boolean('activa')->default(true);
            $table->timestamps();

            // Relaciones
            $table->foreign('curso_id')->references('id_curso')->on('cursos');
            $table->foreign('profesor_id')->references('id_usuario')->on('usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
