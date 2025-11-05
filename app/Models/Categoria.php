<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categoria extends Model
{
        protected $table = 'Categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        
    ];
}
