<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // LISTAR
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    // FORMULARIO CREAR
    public function create()
    {
        return view('productos.create');
    }

    // GUARDAR
    public function store(Request $request)
    {
        Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock'  => $request->stock
        ]);

        return redirect()->route('productos.index');
    }

    // FORMULARIO EDITAR
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    // ACTUALIZAR
    public function update(Request $request, Producto $producto)
    {
        $producto->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock'  => $request->stock
        ]);

        return redirect()->route('productos.index');
    }

    // ELIMINAR
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index');
    }
}

