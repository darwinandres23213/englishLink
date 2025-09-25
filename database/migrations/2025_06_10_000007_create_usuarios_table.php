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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('email', 100)->unique();
            $table->string('contrasena', 255);
            $table->unsignedBigInteger('rol_id');
            $table->unsignedBigInteger('estado_id');
            $table->string('imagen', 255)->nullable(); // Nuevo campo: Imagen de perfil opcional
            //$table->string('imagen', 255)->nullable()->after('email');
            $table->timestamps();

            // Relaciones
            $table->foreign('rol_id')->references('id_rol')->on('roles');
            $table->foreign('estado_id')->references('id_estado')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
