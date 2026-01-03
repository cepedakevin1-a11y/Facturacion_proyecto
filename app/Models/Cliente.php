<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Cliente.php
class Cliente extends Model
{
    protected $fillable = [
        'cedula','nombre','apellido','email','telefono'
    ];
}

