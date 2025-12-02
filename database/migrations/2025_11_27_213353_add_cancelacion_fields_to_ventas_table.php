<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->text('motivo_cancelacion')->nullable()->after('estado');
            $table->foreignId('cancelada_por')->nullable()->constrained('users')->after('motivo_cancelacion');
            $table->timestamp('fecha_cancelacion')->nullable()->after('cancelada_por');
        });
    }

    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign(['cancelada_por']);
            $table->dropColumn(['estado', 'motivo_cancelacion', 'cancelada_por', 'fecha_cancelacion']);
        });
    }
};