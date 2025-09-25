<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('usuario_id');
            $table->string('mensaje', 1000);
            $table->unsignedBigInteger('estado_id');
            $table->enum('tipo', ['Sistema', 'Curso', 'Usuario']);
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamps();

            // Relaciones
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
        });
    }

    
    public function down(): void {
        Schema::dropIfExists('notificaciones');
    }
};
