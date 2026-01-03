@extends('layouts.app')

@section('content')
    <h3>Editar Cliente</h3>

    <form method="POST" action="{{ route('clientes.update',$cliente) }}">
        @csrf @method('PUT')

        <input class="form-control mb-2" name="cedula" value="{{ $cliente->cedula }}">
        <input class="form-control mb-2" name="nombre" value="{{ $cliente->nombre }}">
        <input class="form-control mb-2" name="apellido" value="{{ $cliente->apellido }}">
        <input class="form-control mb-2" name="email" value="{{ $cliente->email }}">
        <input class="form-control mb-2" name="telefono" value="{{ $cliente->telefono }}">

        <button class="btn btn-primary">Actualizar</button>
    </form>
@endsection
