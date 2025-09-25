<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    
    public function up(): void{
        Schema::create('alertas', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('usuario_id');
            $table->time('hora_alerta');
            $table->enum('tipo_alerta', ['sistema', 'curso', 'usuario', 'urgente', 'email', 'sms', 'push'])->default('email');
            $table->string('mensaje');
            $table->unsignedBigInteger('estado_id');
            $table->timestamp('fecha_creacion');
            $table->timestamps();

            //relaciones
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
        });
    }

    public function down(): void{
        Schema::dropIfExists('alertas');
    }
};