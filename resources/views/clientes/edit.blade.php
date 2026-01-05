@extends('layouts.app')
@section('content')
    <h4>Modificar Cliente</h4>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('clientes.update',$cliente) }}">
        @csrf @method('PUT')
        <input class="form-control mb-2" name="cedula" value="{{ $cliente->cedula }}">
        <input class="form-control mb-2" name="nombre" value="{{ $cliente->nombre }}">
        <input class="form-control mb-2" name="apellido" value="{{ $cliente->apellido }}">
        <input class="form-control mb-2" name="correo" value="{{ $cliente->correo }}">
        <input class="form-control mb-2" name="telefono" value="{{ $cliente->telefono }}">
        <input class="form-control mb-2" name="direccion" value="{{ $cliente->direccion }}">
        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
