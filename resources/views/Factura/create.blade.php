@extends('layouts.app')

@section('content')
    <h3>Nuevo Cliente</h3>

    <form method="POST" action="{{ route('clientes.store') }}">
        @csrf

        <input class="form-control mb-2" name="cedula" placeholder="Cédula">
        <input class="form-control mb-2" name="nombre" placeholder="Nombre">
        <input class="form-control mb-2" name="apellido" placeholder="Apellido">
        <input class="form-control mb-2" name="email" placeholder="Email">
        <input class="form-control mb-2" name="telefono" placeholder="Teléfono">

        <button class="btn btn-success">Guardar</button>
    </form>
@endsection
