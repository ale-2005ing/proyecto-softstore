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
        Schema::create('entrada_detalles', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('entrada_id');
    $table->unsignedBigInteger('producto_id');
    $table->integer('cantidad');
    $table->decimal('precio_compra', 10, 2);
    $table->decimal('subtotal', 10, 2);

    $table->foreign('entrada_id')->references('id')->on('entradas')->onDelete('cascade');
    $table->foreign('producto_id')->references('id')->on('productos');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrada_detalles');
    }
};
