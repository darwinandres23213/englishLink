{{-- filepath: resources/views/mensajes/show.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Ver Mensaje')
@section('content')

<div class="container py-4">
    <h1>Mensaje #{{ $mensaje->id }}</h1>
    <p><strong>Remitente:</strong> {{ $mensaje->remitente->nombre ?? 'N/A' }}</p>
    <p><strong>Destinatario:</strong> {{ $mensaje->destinatario->nombre ?? 'N/A' }}</p>
    <p><strong>Contenido:</strong> {{ $mensaje->contenido }}</p>
    <p><strong>Fecha de Envío:</strong> {{ $mensaje->fecha_envio }}</p>
    <p><strong>Leído:</strong> {{ $mensaje->leido ? 'Sí' : 'No' }}</p>
    <a href="{{ route('mensajes.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection