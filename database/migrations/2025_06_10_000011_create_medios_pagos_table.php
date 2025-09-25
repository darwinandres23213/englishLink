<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('medios_pagos', function (Blueprint $table) {
            $table->id('id_medio_pago');
            $table->string('nombre', 100)->unique();
            $table->string('descripcion', 255)->nullable();
            $table->unsignedBigInteger('estado_id');
            $table->timestamps();

            // Relacion con Estados
            $table->foreign('estado_id')->references('id_estado')->on('estados');
        });
    }

    public function down(): void {
        Schema::dropIfExists('medios_pagos');
    }
};
