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
            Schema::create('compras', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('proveedor_id');
        $table->decimal('total', 10, 2);
        $table->timestamps();

        $table->foreign('proveedor_id')->references('id')->on('proveedores')->cascadeOnDelete();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
