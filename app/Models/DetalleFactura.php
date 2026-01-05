<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'factura_id',
        'producto_id',
        'cantidad',
        'precio',
        'subtotal'
    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}
