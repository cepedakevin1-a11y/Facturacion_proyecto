<?php
namespace App\Http\Controllers;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::where('estado', true);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $query->where(function ($q) use ($buscar) {
                $q->where('cedula', 'like', "%$buscar%")
                    ->orWhere('nombre', 'like', "%$buscar%")
                    ->orWhere('apellido', 'like', "%$buscar%");
            });
        }
        $clientes = $query->get();

        return view('clientes.index', compact('clientes'));
    }
    public function create()
    {
        return view('clientes.create');
    }
    public function store(ClienteRequest $request)
    {
        Cliente::create(
            $request->validated() + ['estado' => true]
        );

        return redirect()->route('clientes.index')
            ->with('success', 'Operación realizada correctamente.');
    }
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }
    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $cliente->update($request->validated());

        return redirect()->route('clientes.index')
            ->with('success', 'Operación realizada correctamente.');
    }
    public function destroy(Cliente $cliente)
    {
        $cliente->update(['estado' => false]);

        return redirect()->route('clientes.index')
            ->with('success', 'Operación realizada correctamente.');
    }
}
