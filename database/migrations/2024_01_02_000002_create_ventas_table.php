<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('consecutivo')->unique();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade'); // Usuario con rol cliente
            $table->date('fecha_venta');
            $table->decimal('total', 10, 2);
            $table->date('fecha_fin_garantia')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
