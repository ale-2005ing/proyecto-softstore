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
    Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('descripcion')->nullable();
        $table->decimal('precio', 10, 2);
        $table->integer('stock')->default(0);

        // 🔹 No usar foreignId aquí
        $table->unsignedBigInteger('categoria_id')->nullable();
        $table->unsignedBigInteger('proveedor_id')->nullable();
        
        $table->integer('stock_min')->default(1);
        $table->integer('stock_max')->default(9999);
        $table->timestamps();
        // 🔹 Foreign keys manuales (solo una vez)
        $table->foreign('categoria_id')->references('id')->on('categorias')->nullOnDelete();
         $table->foreign('proveedor_id')->references('id')->on('proveedores')->nullOnDelete();     
    });
}             
              


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
