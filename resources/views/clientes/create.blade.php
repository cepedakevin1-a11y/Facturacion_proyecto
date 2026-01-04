@extends('layouts.app')

@section('content')
    <h4>Registrar Cliente</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST" action="{{ route('clientes.store') }}">
        @csrf

        <input class="form-control mb-2" name="cedula" placeholder="Cédula">
        <input class="form-control mb-2" name="nombre" placeholder="Nombre">
        <input class="form-control mb-2" name="apellido" placeholder="Apellido">
        <input class="form-control mb-2" name="correo" placeholder="Correo electrónico">
        <input class="form-control mb-2" name="telefono" placeholder="Teléfono">
        <input class="form-control mb-2" name="direccion" placeholder="Dirección">

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
