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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('consecutivo')->unique();

            // Cambiado cliente_id para que haga FK a users en vez de clientes
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad');
            $table->date('fecha_venta');
            $table->decimal('total', 10, 2);
            $table->date('fecha_fin_garantia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
