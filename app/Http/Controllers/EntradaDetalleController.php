<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use Illuminate\Http\Request;

class EntradaDetalleController extends Controller
{
    public function show($id)
    {
        // Buscar la entrada
        $entrada = Entrada::with('detalles.producto')->findOrFail($id);

        return view('detalles.show', compact('entrada'));
    }
}
