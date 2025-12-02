<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class LimpiarProductosDuplicados extends Command
{
    protected $signature = 'productos:limpiar-duplicados';
    protected $description = 'Elimina productos duplicados reasignando sus referencias';

    public function handle()
    {
        $duplicados = DB::table('productos')
            ->select('nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('nombre')
            ->having('total', '>', 1)
            ->get();

        if ($duplicados->isEmpty()) {
            $this->info('✅ No hay productos duplicados.');
            return;
        }

        $this->info('🔍 Encontrados ' . $duplicados->count() . ' productos duplicados');

        DB::beginTransaction();

        try {
            foreach($duplicados as $dup) {
                $productos = Producto::where('nombre', $dup->nombre)->orderBy('id')->get();
                $primero = $productos->first();
                
                $this->info("📦 Procesando: {$dup->nombre}");
                
                foreach($productos->skip(1) as $p) {
                    // Reasignar referencias en entrada_detalles
                    $countEntradas = DB::table('entrada_detalles')
                        ->where('producto_id', $p->id)
                        ->update(['producto_id' => $primero->id]);
                    
                    // Reasignar referencias en detalle_ventas
                    $countVentas = DB::table('detalle_ventas')
                        ->where('producto_id', $p->id)
                        ->update(['producto_id' => $primero->id]);
                    
                    // Sumar stocks
                    $primero->stock += $p->stock;
                    $primero->save();
                    
                    $this->warn("  ❌ Eliminando ID: {$p->id} (Stock: {$p->stock})");
                    if ($countEntradas > 0) {
                        $this->line("     → Reasignadas {$countEntradas} entradas");
                    }
                    if ($countVentas > 0) {
                        $this->line("     → Reasignadas {$countVentas} ventas");
                    }
                    
                    $p->delete();
                }
                
                $this->line("  ✅ Producto final: ID {$primero->id} con stock {$primero->stock}");
            }

            DB::commit();
            $this->info('✅ ¡Duplicados eliminados exitosamente!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ Error: ' . $e->getMessage());
        }
    }
}