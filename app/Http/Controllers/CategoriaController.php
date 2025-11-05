<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
            $categorias = Categoria::all();
    return view('categorias.index', compact('categorias'));

        
    }

 public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $categoria = Categoria::create($request->all());
        return $categoria;
    }

    public function show($id)
    {
        return Categoria::findOrFail($id);
    }
    
        public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }


    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());
        return $categoria;
    }

    public function destroy($id)
    {
        return Categoria::destroy($id);
    }
}
