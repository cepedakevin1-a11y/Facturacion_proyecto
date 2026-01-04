<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;

class ProductoController extends Controller
{

    public function index(Request $request)
    {
        $query = Producto::where('estado', true);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%")
                    ->orWhere('descripcion', 'like', "%$buscar%");
            });
        }

        $productos = $query->get();

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(ProductoRequest $request)
    {
        Producto::create($request->validated() + ['estado' => true]);

        return redirect()->route('productos.index')
            ->with('success', 'Operación realizada correctamente.');
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(ProductoRequest $request, Producto $producto)
    {
        $producto->update($request->validated());

        return redirect()->route('productos.index')
            ->with('success', 'Operación realizada correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->update(['estado' => false]);

        return redirect()->route('productos.index')
            ->with('success', 'Operación realizada correctamente.');
    }
}
