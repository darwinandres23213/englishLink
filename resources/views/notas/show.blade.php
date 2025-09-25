{{-- filepath: resources/views/notas/show.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Detalle de Nota')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 50vh; border-radius: 12px;">
    <h2>Detalle de Nota</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>ID:</strong> {{ $nota->id_nota }}</li>
        <li class="list-group-item"><strong>Evaluación:</strong> {{ $nota->evaluacion_id }}</li>
        <li class="list-group-item"><strong>Estudiante:</strong> {{ $nota->estudiante_id }}</li>
        <li class="list-group-item"><strong>Calificación:</strong> {{ $nota->calificacion }}</li>
    </ul>
    <a href="{{ route('notas.index') }}" class="btn btn-secondary mt-3">Volver</a>
    <a href="{{ route('notas.edit', $nota) }}" class="btn btn-warning mt-3">Editar</a>
</div>
@endsection