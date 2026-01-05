<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $productoId = $this->route('producto') ? $this->route('producto')->id : null;

        return [
            'nombre' => 'required|string|max:100|unique:productos,nombre,' . $productoId,
            'descripcion' => 'nullable|string|max:250',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ];
    }
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.unique' => 'El producto ya existe.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
        ];
    }
}
