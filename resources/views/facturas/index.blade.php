@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="mb-3">Gestión de Facturas</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('facturas.create') }}" class="btn btn-primary mb-3">Registrar Factura</a>

        {{-- Card de búsqueda --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('facturas.index') }}" class="row g-2 align-items-end">

                    <div class="col-md-4">
                        <label>Cliente</label>
                        <input type="text" name="buscar" class="form-control" placeholder="Nombre, apellido o cédula" value="{{ request('buscar') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Estado</label>
                        <select name="estado" class="form-control">
                            <option value="">Todos</option>
                            <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>ACTIVA</option>
                            <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>ANULADA</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-secondary w-100">Buscar</button>
                    </div>

                </form>
            </div>
        </div>

        {{-- Tabla de facturas --}}
        <table class="table table-bordered table-striped">
            <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Subtotal</th>
                <th>IVA</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($facturas as $f)
                <tr>
                    <td>{{ $f->id }}</td>
                    <td>{{ $f->cliente->nombre }} {{ $f->cliente->apellido }}</td>
                    <td>{{ number_format($f->subtotal,2) }}</td>
                    <td>{{ number_format($f->iva,2) }}</td>
                    <td>{{ number_format($f->total,2) }}</td>
                    <td>{{ $f->estado == 1 ? 'ACTIVA' : 'ANULADA' }}</td>
                    <td>{{ \Carbon\Carbon::parse($f->fecha)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('facturas.show', $f) }}" class="btn btn-info btn-sm">Ver</a>

                        @if($f->estado == 1)
                            <form action="{{ route('facturas.destroy', $f) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Desea anular esta factura?')">Anular</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No se encontraron facturas.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
