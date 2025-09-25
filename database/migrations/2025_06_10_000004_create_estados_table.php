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
        Schema::create('estados', function (Blueprint $table) {
            $table->id('id_estado');
            $table->unsignedBigInteger('id_tipo_estado');
            $table->string('nombre_estado', 50);
            $table->timestamps();

            // Relaciones
            $table->foreign('id_tipo_estado')->references('id_tipo_estado')->on('tipos_estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};
