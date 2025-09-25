{{-- filepath: resources/views/evaluaciones/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Lista de Evaluaciones')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Lista de Evaluaciones</h1>
    <div class="mb-3">
        <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary">Nueva Evaluación</a>
    </div>
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Curso</th>
                    <th>Título</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evaluaciones as $eva)
                    <tr>
                        <td>{{ $eva->id_evaluacion }}</td>
                        <td>{{ $eva->curso->nombre_curso ?? $eva->curso_id }}</td>
                        <td>{{ $eva->titulo }}</td>
                        <td>
                            <a href="{{ route('evaluaciones.edit', $eva) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('evaluaciones.destroy', $eva) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar evaluación?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $evaluaciones->links('pagination::bootstrap-5') }}    
        </div>
    </div>
</div>
@endsection