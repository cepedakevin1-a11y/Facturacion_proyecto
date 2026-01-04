<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre', 'precio', 'stock', 'estado'
    ];

    public $timestamps = false;

    // Relación con facturas
    public function facturas()
    {
        return $this->belongsToMany(Factura::class, 'factura_producto')
            ->withPivot('cantidad');
    }
}
