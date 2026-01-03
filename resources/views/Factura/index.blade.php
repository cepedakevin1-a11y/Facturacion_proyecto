@extends('layouts.app')

@section('content')
    <h3>Clientes</h3>

    <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-2">Nuevo Cliente</a>

    <table class="table table-bordered">
        <tr>
            <th>Cédula</th><th>Nombre</th><th>Acciones</th>
        </tr>

        @foreach($clientes as $c)
            <tr>
                <td>{{ $c->cedula }}</td>
                <td>{{ $c->nombre }} {{ $c->apellido }}</td>
                <td>
                    <a href="{{ route('clientes.edit',$c) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('clientes.destroy',$c) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
