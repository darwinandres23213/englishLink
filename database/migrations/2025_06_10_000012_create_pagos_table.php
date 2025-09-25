<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->unsignedBigInteger('matricula_id');
            //$table->unsignedBigInteger('estudiante_id');
            $table->decimal('monto', 10, 2);
            $table->date('fecha_pago');
            $table->unsignedBigInteger('estado_pago_id');
            $table->unsignedBigInteger('medio_pago_id');
            $table->timestamps();

            // Relaciones
            $table->foreign('matricula_id')->references('id_matricula')->on('matriculas');
            //$table->foreign('estudiante_id')->references('id_usuario')->on('usuarios');
            $table->foreign('estado_pago_id')->references('id_estado')->on('estados');
            $table->foreign('medio_pago_id')->references('id_medio_pago')->on('medios_pagos');
        });
    }

    
    public function down(): void {
        Schema::dropIfExists('pagos');
    }
};