@extends('layouts.app')
@section('content')
    <div class="container">
        <h4 class="mb-3">Detalle de Factura #{{ $factura->id }}</h4>
        {{-- Mensajes --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        {{-- Datos del cliente --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5>Cliente</h5>
                <p>
                    <strong>Nombre:</strong> {{ $factura->cliente->nombre }} {{ $factura->cliente->apellido }} <br>
                    <strong>Cédula:</strong> {{ $factura->cliente->cedula }} <br>
                    <strong>Estado:</strong> {{ $factura->estado == 1 ? 'ACTIVA' : 'ANULADA' }}
                </p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</p>
            </div>
        </div>
        {{-- Productos --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5>Productos</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($factura->productos as $producto)
                        <tr>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ number_format($producto->precio, 2) }}</td>
                            <td>{{ $producto->pivot->cantidad }}</td>
                            <td>{{ number_format($producto->precio * $producto->pivot->cantidad, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Totales --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5>Totales</h5>
                <p>
                    <strong>Subtotal:</strong> {{ number_format($factura->subtotal, 2) }} <br>
                    <strong>IVA (12%):</strong> {{ number_format($factura->iva, 2) }} <br>
                    <strong>Total:</strong> {{ number_format($factura->total, 2) }}
                </p>
            </div>
        </div>
        <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Volver a Facturas</a>
    </div>
@endsection
