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
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $factura = Factura::create([
                'cliente_id' => $request->cliente_id,
                'fecha' => now(),
                'subtotal' => 0,
                'iva' => 0,
                'total' => 0,
                'estado' => 1
            ]);
            foreach ($request->productos as $p) {
                $producto = Producto::find($p['producto_id']);
                $cantidad = $p['cantidad'];

                if ($cantidad > 0) {
                    $factura->productos()->attach($producto->id, ['cantidad' => $cantidad]);
                    $subtotal += $producto->precio * $cantidad;
                    $producto->stock -= $cantidad;
                    $producto->save();
                }
            }

            $iva = $subtotal * 0.12;
            $total = $subtotal + $iva;

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
    public function update(Request $request, Factura $factura)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $factura->cliente_id = $request->cliente_id;
            $factura->save();

            foreach ($factura->productos as $p) {
                $p->stock += $p->pivot->cantidad;
                $p->save();
            }

            $factura->productos()->detach();

            $subtotal = 0;

            foreach ($request->productos as $p) {
                $producto = Producto::find($p['producto_id']);
                $cantidad = $p['cantidad'];

                if ($cantidad > 0) {
                    $factura->productos()->attach($producto->id, ['cantidad' => $cantidad]);

                    $subtotal += $producto->precio * $cantidad;

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
