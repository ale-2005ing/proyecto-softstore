<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up()
{
    Schema::table('clientes', function (Blueprint $table) {
        $table->enum('estado', ['activo', 'moroso', 'inactivo'])
            ->default('activo')
            ->after('direccion');
    });
              
}

public function down()
{
    Schema::table('clientes', function (Blueprint $table) {
        $table->dropColumn('estado');
    });
}
};
