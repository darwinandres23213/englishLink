{{-- filepath: resources/views/notas/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Lista de Notas')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Lista de Notas</h1>
    <div class="mb-3">
        <a href="{{ route('notas.create') }}" class="btn btn-primary">Nueva Nota</a>
    </div>
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Evaluación</th>
                    <th>Estudiante</th>
                    <th>Calificación</th>
                    <th class="text-nowrap text-center" style="width: 140px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notas as $nota)
                    <tr>
                        <td>{{ $nota->id_nota }}</td>
                        <td>{{ $nota->evaluacion_id }}</td>
                        <td>{{ $nota->estudiante_id }}</td>
                        <td>{{ $nota->calificacion }}</td>
                        <td class="text-center">
                            <a href="{{ route('notas.show', $nota) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('notas.edit', $nota) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('notas.destroy', $nota) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar nota?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{-- $notas->links('pagination::bootstrap-5') --}}
        </div>
    </div> -->
</div>
@endsection