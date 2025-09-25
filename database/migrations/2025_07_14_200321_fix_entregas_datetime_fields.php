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
        Schema::table('entregas_actividades', function (Blueprint $table) {
            // Asegurar que los campos de fecha sean del tipo correcto
            $table->timestamp('fecha_entrega')->nullable()->change();
            $table->timestamp('fecha_calificacion')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entregas_actividades', function (Blueprint $table) {
            $table->timestamp('fecha_entrega')->nullable()->change();
            $table->timestamp('fecha_calificacion')->nullable()->change();
        });
    }
};
