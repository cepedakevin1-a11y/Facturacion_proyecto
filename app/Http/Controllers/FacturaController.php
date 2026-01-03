<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cliente;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    // LISTAR
    public function index()
    {
        $facturas = Factura::with('cliente')->get();
        return view('facturas.index', compact('facturas'));
    }

    // FORMULARIO CREAR
    public function create()
    {
        $clientes = Cliente::all();
        return view('facturas.create', compact('clientes'));
    }

    // GUARDAR
    public function store(Request $request)
    {
        Factura::create([
            'cliente_id' => $request->cliente_id,
            'fecha'      => now(),
            'total'      => $request->total ?? 0
        ]);

        return redirect()->route('facturas.index');
    }

    // FORMULARIO EDITAR
    public function edit(Factura $factura)
    {
        $clientes = Cliente::all();
        return view('facturas.edit', compact('factura','clientes'));
    }

    // ACTUALIZAR
    public function update(Request $request, Factura $factura)
    {
        $factura->update([
            'cliente_id' => $request->cliente_id,
            'total'      => $request->total
        ]);

        return redirect()->route('facturas.index');
    }

    // ELIMINAR
    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('facturas.index');
    }
}
