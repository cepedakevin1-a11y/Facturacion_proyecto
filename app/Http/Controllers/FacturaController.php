<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{

    public function index(Request $request)
    {
        $query = Factura::with('cliente')->orderBy('fecha', 'desc');


        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('cliente', function($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%")
                    ->orWhere('apellido', 'like', "%$buscar%")
                    ->orWhere('cedula', 'like', "%$buscar%");
            });
        }


        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }


        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        $facturas = $query->get();

        return view('facturas.index', compact('facturas'));
    }


    public function create()
    {
        $clientes = Cliente::where('estado', 1)->get();
        $productos = Producto::where('estado', 1)->get();

        return view('facturas.create', compact('clientes', 'productos'));
    }

    // STORE: crear nueva factura con detalle
    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;

            // Crear factura sin totales
            $factura = Factura::create([
                'cliente_id' => $request->cliente_id,
                'fecha' => now(),
                'subtotal' => 0,
                'iva' => 0,
                'total' => 0,
                'estado' => 1
            ]);

            // Guardar productos en tabla pivote y actualizar stock
            foreach ($request->productos as $p) {
                $producto = Producto::find($p['producto_id']);
                $cantidad = $p['cantidad'];

                if ($cantidad > 0) {
                    $factura->productos()->attach($producto->id, ['cantidad' => $cantidad]);

                    // Sumar subtotal
                    $subtotal += $producto->precio * $cantidad;

                    // Restar stock
                    $producto->stock -= $cantidad;
                    $producto->save();
                }
            }

            // Calcular IVA y total
            $iva = $subtotal * 0.12;
            $total = $subtotal + $iva;

            // Actualizar totales
            $factura->update([
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total,
            ]);

            DB::commit();

            return redirect()->route('facturas.index')
                ->with('success','Factura generada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error','Error: '.$e->getMessage());
        }
    }

    // UPDATE: modificar factura y detalle
    public function update(Request $request, Factura $factura)
    {
        // Validaciones
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            // Actualizar cliente
            $factura->cliente_id = $request->cliente_id;
            $factura->save();

            // Restablecer stock de productos anteriores
            foreach ($factura->productos as $p) {
                $p->stock += $p->pivot->cantidad;
                $p->save();
            }

            // Quitar productos anteriores de la factura
            $factura->productos()->detach();

            $subtotal = 0;

            // Guardar productos nuevos
            foreach ($request->productos as $p) {
                $producto = Producto::find($p['producto_id']);
                $cantidad = $p['cantidad'];

                if ($cantidad > 0) {
                    $factura->productos()->attach($producto->id, ['cantidad' => $cantidad]);

                    // Sumar subtotal
                    $subtotal += $producto->precio * $cantidad;

                    // Restar stock actualizado
                    $producto->stock -= $cantidad;
                    $producto->save();
                }
            }

            // Recalcular IVA y total
            $iva = $subtotal * 0.12;
            $total = $subtotal + $iva;

            $factura->update([
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total
            ]);

            DB::commit();

            return redirect()->route('facturas.index')
                ->with('success','Factura actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error','Error: '.$e->getMessage());
        }
    }


    public function show(Factura $factura)
    {
        $factura->load('cliente', 'productos');
        return view('facturas.show', compact('factura'));
    }


    public function destroy(Factura $factura)
    {
        $factura->estado = 0;
        $factura->save();

        return redirect()->route('facturas.index')
            ->with('success', 'Factura anulada correctamente.');
    }
}
