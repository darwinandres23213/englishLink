{{-- filepath: resources/views/historial_imagenes/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Historial de Imágenes')
@section('content')

@if(session('success'))
    {{-- Copia aquí el toast de éxito igual que en medios_pago --}}
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Historial de Imágenes</h1>

    <div class="mb-3">
        <a href="{{ route('historial_imagenes.create') }}" class="btn btn-primary mb-3 mb-md-0">Subir Nueva Imagen</a>
    </div>

    {{-- Filtros para buscar imágenes }}
    <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
        <div>
            {{-- Filtros para buscar imágenes por usuario o fecha --}} {{--
            <form method="GET" action="{{ route('historial_imagenes.index') --}} {{-- " class="mb-3 mb-md-0 d-flex gap-2">
                <input type="text" name="usuario" class="form-control flex-grow-1" style="min-width:200px" placeholder="Buscar por usuario" value="{{ request('usuario') }}">
                <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div>
    </div> --}}

    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Imagen</th>
                    <th>Fecha de Subida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($imagenes as $imagen)
                    <tr class="text-center">
                        <td>{{ $imagen->id }}</td>
                        <td>{{ $imagen->usuario_id }}</td>
                        <td>
                            @php
                                $ruta = public_path('uploads/' . $imagen->nombre_imagen);
                            @endphp
                            @if(file_exists($ruta))
                                <img src="{{ asset('uploads/' . $imagen->nombre_imagen) }}" alt="Imagen" width="60">
                            @else
                                <span class="text-muted">Sin imagen</span>
                            @endif
                        </td>
                        <td>{{ $imagen->fecha_subida ?? $imagen->created_at }}</td>
                        <td>
                            <a href="{{ asset('uploads/' . $imagen->nombre_imagen) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye" title="Ver Imagen"></i>
                            </a>
                            <form action="{{ route('historial_imagenes.destroy', $imagen->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta imagen?')">
                                    <i class="bi bi-trash" title="Eliminar Imagen"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $imagenes->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection