<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\FacturaController;

Route::get('/', function () {
    return redirect()->route('clientes.index');
});

Route::resource('clientes', ClienteController::class);
Route::resource('productos', ProductoController::class);
Route::resource('facturas', FacturaController::class);

