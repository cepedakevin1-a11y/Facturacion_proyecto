<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable = ['cliente_id','fecha','total'];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }
}

