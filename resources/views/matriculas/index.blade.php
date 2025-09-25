{{-- filepath: resources/views/matriculas/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Matrículas')
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
    <h1 class="mb-4 fw-bold">Matrículas</h1>

    {{-- Botón para crear una nueva matrícula --}}
    <div class="mb-3">
        <a href="{{ route('matriculas.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus me-2"></i>Nueva Matrícula
        </a>
    </div>

    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0 table-fixed">
            <thead class="table-light">
                <tr class="text-center">
                    <th class="col-1">ID</th>
                    <th class="col-4 text-start">Estudiante</th>
                    <th class="col-3">Curso</th>
                    <th class="col-2">Fecha Matrícula</th>
                    <th class="col-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matriculas as $matricula)
                    <tr class="text-center">
                        <td>{{ $matricula->id_matricula }}</td>

                        <td class="text-start">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3">
                                    {{ substr($matricula->estudiante->nombre ?? 'N', 0, 1) }}{{ substr($matricula->estudiante->apellido ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $matricula->estudiante->nombre ?? 'N/A' }} {{ $matricula->estudiante->apellido ?? '' }}</div>
                                    @if($matricula->estudiante && $matricula->estudiante->email)
                                        <small class="text-muted">{{ $matricula->estudiante->email }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            <div>
                                <span class="fw-bold">{{ $matricula->curso->nombre_curso ?? 'N/A' }}</span>
                                @if($matricula->curso && $matricula->curso->nivel)
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-layer-group me-1"></i>{{ $matricula->curso->nivel->nombre_nivel }}
                                    </small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y') }}</span>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($matricula->fecha_matricula)->diffForHumans() }}
                                </small>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('matriculas.edit', $matricula->id_matricula) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar matrícula">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('matriculas.destroy', $matricula->id_matricula) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="confirmarEliminacion(this)" 
                                        data-estudiante="{{ $matricula->estudiante->nombre ?? 'N/A' }} {{ $matricula->estudiante->apellido ?? '' }}"
                                        data-curso="{{ $matricula->curso->nombre_curso ?? 'N/A' }}"
                                        title="Eliminar matrícula">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($matriculas->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay matrículas registradas</h5>
                            <p class="text-muted">Comienza creando la primera matrícula</p>
                            <a href="{{ route('matriculas.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Nueva Matrícula
                            </a>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $matriculas->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
    .table-fixed {
        table-layout: fixed;
    }
    
    .avatar-sm {
        width: 35px;
        height: 35px;
        font-size: 12px;
        font-weight: 600;
    }
</style>

<script>
function confirmarEliminacion(button) {
    const estudiante = button.getAttribute('data-estudiante');
    const curso = button.getAttribute('data-curso');
    
    if (confirm(`¿Estás seguro de que deseas eliminar la matrícula de ${estudiante} en el curso ${curso}?`)) {
        button.closest('form').submit();
    }
}
</script>
@endsection