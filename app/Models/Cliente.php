<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'direccion',
        'estado'
    ];

    // 🔗 Relación: un cliente tiene muchas facturas
    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }
}
