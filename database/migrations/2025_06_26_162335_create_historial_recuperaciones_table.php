<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('historial_recuperaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_recuperacion');
            $table->decimal('nota_anterior', 3, 1);
            $table->decimal('nota_nueva', 3, 1);
            $table->date('fecha_cambio');
            $table->string('modificado_por');
            $table->timestamps();
            // Relaciones
            $table->foreign('id_recuperacion')->references('id')->on('recuperaciones');
        });
    }

    public function down(): void {
        Schema::dropIfExists('historial_recuperaciones');
    }
};