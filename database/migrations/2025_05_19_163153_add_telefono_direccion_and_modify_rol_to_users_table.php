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
        Schema::table('users', function (Blueprint $table) {
            // Modificar columna rol a enum, primero hay que cambiar el tipo
            // Para modificar tipo en MySQL necesitas instalar doctrine/dbal
            // Si no lo tienes: composer require doctrine/dbal

            $table->enum('rol', ['admin', 'cliente'])->default('cliente')->change();
            // Agregar campos telefono y direccion después de rol
            $table->string('telefono')->nullable()->after('rol');
            $table->string('direccion')->nullable()->after('telefono');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir cambios

            // Volver rol a string
            $table->string('rol')->change();

            // Eliminar columnas telefono y direccion
            $table->dropColumn(['telefono', 'direccion']);
        });
    }
};
