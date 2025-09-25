{{-- filepath: resources/views/cursos/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Cursos')
@section('content')

@if(session('success'))
    <div id="toast-success"
        style="
            position: fixed;
            top: 100px;
            left: 75%;
            transform: translateX(-50%);
            z-index: 9999;
            min-width: 340px;
            max-width: 400px;
            background: #b7eac7;
            color: #155724;
            border-radius: 4px;
            box-shadow: 0 4px 24px #1199319f;
            padding: 18px 24px 12px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            opacity: 1;
            transition: opacity 0.5s;
        ">
        <div style="display: flex; align-items: center; margin-bottom: 4px;">
            <svg width="22" height="22" fill="none" stroke="#155724" stroke-width="2" viewBox="0 0 24 24" style="margin-right: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span style="font-weight: bold; font-size: 1.1em;">¡Éxito!</span>
        </div>
        <div style="margin-bottom: 8px; margin-left: 30px;">{{ session('success') }}</div>
        <div style="width: 100%; height: 5px; background: #d4f5e9; border-radius: 3px; overflow: hidden;">
            <div id="toast-progress" style="height: 5px; background: #218838; width: 100%; transition: width 0.3s;"></div>
        </div>
    </div>
    <script>
        const toastDuration = 2200;
        const progressBar = document.getElementById('toast-progress');
        let width = 100;
        const interval = 20;
        const decrement = 100 / (toastDuration / interval);

        const timer = setInterval(() => {
            width -= decrement;
            if (progressBar) progressBar.style.width = width + '%';
            if (width <= 0) {
                clearInterval(timer);
            }
        }, interval);

        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if(toast) toast.style.opacity = '0';
        }, toastDuration);
    </script>
@endif

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Cursos</h1>

    {{-- Botón para crear un nuevo curso --}}
    <div class="mb-3">
        <a href="{{ route('cursos.create') }}" class="btn btn-primary mb-3">Nuevo Curso</a>
    </div>

    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0 table-fixed">
            <thead class="table-light">
                <tr class="text-center">
                    <th class="col-1">ID</th>
                    <th class="col-4 text-start">Curso y descripción</th>
                    <!-- <th>Descripción</th> -->
                    <th class="col-2">Nivel</th>
                    <th class="col-2">Horario</th>
                    <th class="col-2">Profesor</th>
                    <th class="col-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cursos as $curso)
                    <tr class="text-center">
                        <td>{{ $curso->id_curso }}</td>
                        {{-- <td>{{ $curso->nombre_curso }}</td>
                        <td>{{ $curso->descripcion }}</td> --}}
                        <td class="text-start">
                            <div>
                                {{ $curso->nombre_curso }}
                                @if($curso->descripcion)
                                    <br>
                                    <small class="text-muted">{{ Str::limit($curso->descripcion, 50) }}</small>
                                @endif
                            </div>
                        </td>

                        <td>{{ $curso->nivel->nombre_nivel ?? 'N/A' }}</td>

                        <td>
                            @if($curso->horario)
                                <div>
                                    {{ $curso->horario->nombre_horario }}
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($curso->horario->hora_inicio)->format('g:i A') }} - {{ \Carbon\Carbon::parse($curso->horario->hora_fin)->format('g:i A') }}
                                        <!--
                                            H:i → 14:30 (formato 24 horas)
                                            g:i A → 2:30 PM (formato 12 horas con AM/PM)
                                            h:i A → 02:30 PM (formato 12 horas con cero inicial)
                                        -->
                                    </small>
                                </div>
                            @else
                                <span class="text-muted">Sin horario asignado</span>
                            @endif
                        </td>

                        <td>{{ $curso->profesor->nombre ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('cursos.edit', $curso) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil" title="Editar curso"></i>
                            </a>
                            <form action="{{ route('cursos.destroy', $curso) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este curso?')">
                                    <i class="bi bi-trash" title="Eliminar curso"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($cursos->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No hay cursos registrados.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $cursos->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>


<style>
    .table-fixed {
        table-layout: fixed;
    }
</style>


@endsection