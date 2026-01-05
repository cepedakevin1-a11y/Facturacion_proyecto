<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Facturación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">Facturación</a>
        <div>
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-light btn-sm">Clientes</a>
            <a href="{{ route('productos.index') }}" class="btn btn-outline-light btn-sm">Productos</a>
            <a href="{{ route('facturas.index') }}" class="btn btn-outline-light btn-sm">Facturas</a>
        </div>
    </div>
</nav>
<div class="container">
    {{-- Mensajes Estándares--}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    {{-- Errores de validación --}}
    @if($errors->any())
        <div class="alert alert-warning">
            {{ $errors->first() }}
        </div>
    @endif
    @yield('content')
</div>
</body>
</html>
