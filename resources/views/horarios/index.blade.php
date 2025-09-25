{{-- filepath: resources/views/horarios/index.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Lista de Horarios')
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
    <h1 class="mb-4 fw-bold">Horarios</h1>

    <div class="mb-3">
        <a href="{{ route('horarios.create') }}" class="btn btn-primary">Nuevo Horario</a>
    </div>

    {{-- Tabla de horarios --}}
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0 table-fixed">
            <thead class="table-light">
                <tr class="text-center"> {{-- style="width: 20%;" --}}
                    <th>ID</th>
                    <th class="text-start">Nombre</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($horarios as $horario)
                    <tr class="text-center">
                        <td>{{ $horario->id_horario }}</td>
                        <td class="text-start">{{ $horario->nombre_horario }}</td>
                        {{-- <td>{{ $horario->hora_inicio }}</td>
                        <td>{{ $horario->hora_fin }}</td> --}}
                        <td>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}</td>

                        <td class="text-center">
                            {{-- Botones de acción --}}
                            <a href="{{ route('horarios.edit', $horario) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil" title="Editar horario"></i>
                            </a>
                            <form id="delete-form-{{ $horario->id_horario }}" action="{{ route('horarios.destroy', $horario) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $horario->id_horario }}, '{{ $horario->nombre_horario }}')">
                                    <i class="bi bi-trash" title="Eliminar horario"></i>
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
            {{ $horarios->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
    .table-fixed {
        table-layout: fixed;
    }
</style>

<script>
function confirmDelete(horarioId, nombreHorario) {
    Swal.fire({
        title: '¿Estás seguro?',
        html: `¿Deseas eliminar el horario "<strong>${nombreHorario}</strong>"?<br><small class="text-muted">Esta acción no se puede deshacer.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-trash me-1"></i>Sí, eliminar',
        cancelButtonText: '<i class="bi bi-x-circle me-1"></i>Cancelar',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary',
            actions: 'gap-2 d-flex justify-content-center' // Añade espacio entre botones
        },
        buttonsStyling: false,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading mientras se procesa
            Swal.fire({
                title: 'Eliminando...',
                text: 'Por favor espera',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Enviar el formulario
            document.getElementById(`delete-form-${horarioId}`).submit();
        }
    });
}
</script>

@endsection