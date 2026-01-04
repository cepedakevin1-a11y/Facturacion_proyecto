@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="mb-3">Gestión de Productos</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Registrar Producto</a>

        <form method="GET" action="{{ route('productos.index') }}" class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o descripción" value="{{ request('buscar') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-secondary">Consultar</button>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($productos as $p)
                <tr>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->descripcion }}</td>
                    <td>{{ $p->precio }}</td>
                    <td>{{ $p->stock }}</td>
                    <td>
                        <a href="{{ route('productos.edit',$p) }}" class="btn btn-warning btn-sm">Modificar</a>

                        <form action="{{ route('productos.destroy',$p) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar el producto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No existen productos disponibles para la operación.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
