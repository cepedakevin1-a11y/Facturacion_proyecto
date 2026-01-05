@extends('layouts.app')
@section('content')
    <div class="container">
        <h4>Modificar Factura #{{ $factura->id }}</h4>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('facturas.update', $factura) }}">
            @csrf
            @method('PUT')
            {{-- Selección de cliente --}}
            <div class="mb-3">
                <label>Cliente *</label>
                <select name="cliente_id" class="form-control">
                    <option value="">Seleccione cliente</option>
                    @foreach($clientes as $c)
                        <option value="{{ $c->id }}"
                            {{ old('cliente_id', $factura->cliente_id) == $c->id ? 'selected' : '' }}>
                            {{ $c->nombre }} {{ $c->apellido }}
                        </option>
                    @endforeach
                </select>
                @error('cliente_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <hr>
            {{-- Productos --}}
            <h5>Productos</h5>
            @foreach($productos as $p)
                @php
                    $cantidad = 0;
                    if($factura->productos->contains($p->id)){
                        $cantidad = $factura->productos->find($p->id)->pivot->cantidad;
                    }
                @endphp
                <div class="row mb-2">
                    <div class="col-md-6">
                        {{ $p->nombre }} (Stock: {{ $p->stock }})
                    </div>
                    <div class="col-md-3">
                        <input type="number" min="1"
                               name="productos[{{ $loop->index }}][cantidad]"
                               class="form-control"
                               placeholder="Cantidad"
                               value="{{ old('productos.'.$loop->index.'.cantidad', $cantidad) }}">
                        <input type="hidden"
                               name="productos[{{ $loop->index }}][producto_id]"
                               value="{{ $p->id }}">
                        @error('productos.'.$loop->index.'.cantidad')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            @endforeach
            <button class="btn btn-primary mt-3">Actualizar Factura</button>
            <a href="{{ route('facturas.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
        </form>
    </div>
@endsection
