<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'cedula'    => 'required|digits:10|unique:clientes,cedula',
            'nombre'    => 'required|string|max:50',
            'apellido'  => 'required|string|max:50',
            'correo'    => 'nullable|email|max:100',
            'telefono'  => 'nullable|digits_between:7,10',
            'direccion' => 'nullable|string|max:150'
        ];
    }
    public function messages(): array
    {
        return [
            'cedula.required' => 'Existen campos obligatorios sin completar.',
            'cedula.unique'   => 'La información ingresada no es válida. La cédula ya existe.',
            'cedula.digits_between' => 'La información ingresada no es válida.',
            'correo.email'    => 'La información ingresada no es válida.',
        ];
    }
}
