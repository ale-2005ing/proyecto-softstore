<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nette\Schema\Schema as NetteSchema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
     Schema::create('ventas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('cliente_id')->nullable()->constrained()->nullOnDelete();
        // Número de factura (F-2025-000001)
        $table->string('numero')->unique();
        // Fecha de emisión
        $table->dateTime('fecha');
        // Totales
        $table->decimal('subtotal', 12, 2);
        $table->decimal('impuesto', 12, 2)->default(0);
        $table->decimal('descuento', 12, 2)->default(0);
        $table->decimal('total', 12, 2);
        // Datos adicionales
        $table->string('tipo_pago')->default('efectivo'); // efectivo|tarjeta|transferencia
        $table->string('estado')->default('emitida');     // emitida|pendiente|anulada
        $table->string('nota')->nullable();
        // Factura electrónica JSON si aplicas
        $table->json('datos_electronicos')->nullable();
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
