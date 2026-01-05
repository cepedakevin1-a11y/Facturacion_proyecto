@extends('layouts.app')
@section('content')
    <h4>Modificar Producto</h4>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('productos.update', $producto) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre *</label>
            <input type="text" name="nombre"
                   class="form-control"
                   value="{{ old('nombre', $producto->nombre) }}">
            @error('nombre')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Precio *</label>
            <input type="number" step="0.01" name="precio"
                   class="form-control"
                   value="{{ old('precio', $producto->precio) }}">
            @error('precio')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Stock *</label>
            <input type="number" name="stock"
                   class="form-control"
                   value="{{ old('stock', $producto->stock) }}">
            @error('stock')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
