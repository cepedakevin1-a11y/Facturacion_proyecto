<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';

    protected $fillable = [
        'cliente_id', 'fecha', 'subtotal', 'iva', 'total', 'estado'
    ];

    public $timestamps = false;


    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }


    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'factura_producto')
            ->withPivot('cantidad');
    }
}
