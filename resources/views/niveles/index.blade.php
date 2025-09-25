{{-- filepath: resources/views/niveles/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Niveles')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Niveles</h1>

    {{-- Botón para crear un nuevo nivel --}}
    <div class="mb-3">
        <a href="{{ route('niveles.create') }}" class="btn btn-primary mb-3">Nuevo Nivel</a>
    </div>

    {{-- Tabla de niveles --}}
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Nombre del Nivel</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($niveles as $nivel)
                    <tr class="text-center">
                        <td>{{ $nivel->id_nivel }}</td>
                        <td>{{ $nivel->nombre_nivel }}</td>
                        <td>
                            <a href="{{ route('niveles.edit', $nivel->id_nivel) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil" title="Editar nivel"></i>
                            </a>
                            <form action="{{ route('niveles.destroy', $nivel->id_nivel) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este nivel?')">
                                    <i class="bi bi-trash" title="Eliminar nivel"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($niveles->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center">No hay niveles registrados.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 text-end">
             {{ $niveles->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection