<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
{
    public function authorize()
    {
        // ajustar según tu lógica de permisos; por defecto true si estás autenticado
        return \Illuminate\Support\Facades\Auth::check();

    }

    public function rules()
    {
        return [
            'cliente_id' => 'nullable|exists:clientes,id',
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.precio' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'items.required' => 'Debes añadir al menos un producto.',
            'items.*.producto_id.required' => 'Producto inválido en una línea.',
            'items.*.cantidad.required' => 'La cantidad es requerida.',
            'items.*.precio.required' => 'El precio es requerido.'
        ];
    }
}
