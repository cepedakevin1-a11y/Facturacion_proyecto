@extends('layouts.app')

@section('content')
    <div class="container">

        <h4 class="mb-3">Gestión de Clientes</h4>

        {{-- MENSAJES --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- BOTÓN REGISTRAR --}}
        <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">
            Registrar Cliente
        </a>

        {{-- FORMULARIO DE CONSULTA --}}
        <form method="GET" action="{{ route('clientes.index') }}" class="row mb-3">
            <div class="col-md-4">
                <input type="text"
                       name="buscar"
                       class="form-control"
                       placeholder="Buscar por cédula, nombre o apellido"
                       value="{{ request('buscar') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-secondary">Consultar</button>
            </div>
        </form>

        {{-- TABLA --}}
        <table class="table table-bordered table-striped">
            <thead class="table-light">
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($clientes as $c)
                <tr>
                    <td>{{ $c->cedula }}</td>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ $c->apellido }}</td>
                    <td>
                        <a href="{{ route('clientes.edit',$c) }}"
                           class="btn btn-warning btn-sm">
                            Modificar
                        </a>

                        <form action="{{ route('clientes.destroy',$c) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Desea eliminar el cliente?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        No existen clientes disponibles para la operación.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
@endsection
