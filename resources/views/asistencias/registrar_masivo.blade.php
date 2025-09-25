{{-- filepath: resources/views/asistencias/registrar_masivo.blade.php --}}
@extends('layouts.AreaInterna.app')
@section('title', 'Registrar Asistencias por Clase')
@section('content')

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-clipboard-check me-2 text-primary"></i>
                        Registrar Asistencias por Clase
                    </h1>
                    <p class="mb-0 text-muted">Registra la asistencia de todos los estudiantes de una clase</p>
                </div>
                <a href="{{ route('asistencias.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list me-1"></i>
                    Ver Lista de Asistencias
                </a>
            </div>
        </div>
    </div>

    <!-- Formulario de selección de clase -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-search me-2"></i>
                Seleccionar Clase
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('asistencias.registrar.masivo') }}">
                <div class="row">
                    <div class="col-md-6">
                        <label for="clase_id" class="form-label">Clase <span class="text-danger">*</span></label>
                        <select name="clase_id" id="clase_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Seleccione una clase</option>
                            @foreach($clases as $clase)
                                <option value="{{ $clase->id_clase }}" {{ request('clase_id') == $clase->id_clase ? 'selected' : '' }}>
                                    {{ $clase->tema }} - {{ $clase->fecha ? \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') : 'Sin fecha' }}
                                    @if($clase->curso)
                                        ({{ $clase->curso->nombre_curso }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>
                            Buscar Estudiantes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(request('clase_id') && $estudiantes && $estudiantes->count() > 0)
        <!-- Información de la clase seleccionada -->
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-info-circle me-2"></i>
                    Información de la Clase
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Tema:</strong> {{ $claseSeleccionada->tema ?? 'N/A' }}<br>
                        <strong>Fecha:</strong> {{ $claseSeleccionada->fecha ? \Carbon\Carbon::parse($claseSeleccionada->fecha)->format('d/m/Y') : 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Curso:</strong> {{ $claseSeleccionada->curso->nombre_curso ?? 'N/A' }}<br>
                        <strong>Estudiantes matriculados:</strong> {{ $estudiantes->count() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario de registro masivo -->
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-users me-2"></i>
                    Registrar Asistencias ({{ $estudiantes->count() }} estudiantes)
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('asistencias.store.masivo') }}">
                    @csrf
                    <input type="hidden" name="clase_id" value="{{ request('clase_id') }}">
                    
                    <!-- Botones de acción rápida -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-success" onclick="marcarTodos(1)">
                                    <i class="fas fa-check-double me-1"></i>
                                    Marcar Todos Presentes
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="marcarTodos(2)">
                                    <i class="fas fa-clock me-1"></i>
                                    Marcar Todos Tarde
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="marcarTodos(0)">
                                    <i class="fas fa-times me-1"></i>
                                    Marcar Todos Ausentes
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Estudiante</th>
                                    <th>Email</th>
                                    <th width="300" class="text-center">Estado de Asistencia</th>
                                    <th width="100" class="text-center">Estado Actual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estudiantes as $index => $estudiante)
                                    <tr class="{{ $estudiante->asistencia_registrada ? 'table-light' : '' }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $iniciales = strtoupper(substr($estudiante->nombre, 0, 1) . substr($estudiante->apellido ?? '', 0, 1));
                                                    $colores = ['primary', 'success', 'info', 'warning', 'danger'];
                                                    $colorIndex = abs(crc32($estudiante->nombre)) % count($colores);
                                                    $color = $colores[$colorIndex];
                                                @endphp
                                                <div class="bg-{{ $color }} rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 40px; height: 40px; font-size: 14px;">
                                                    {{ $iniciales }}
                                                </div>
                                                <div>
                                                    <strong>{{ $estudiante->nombre }} {{ $estudiante->apellido }}</strong>
                                                    @if($estudiante->asistencia_registrada)
                                                        <br><small class="text-info"><i class="fas fa-info-circle me-1"></i>Ya registrado</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $estudiante->email ?? 'Sin email' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <input type="radio" class="btn-check" name="asistencia[{{ $estudiante->id_usuario }}]" 
                                                       id="presente_{{ $estudiante->id_usuario }}" value="1" 
                                                       {{ ($estudiante->estado_asistencia === 1 || (!$estudiante->asistencia_registrada)) ? 'checked' : '' }}>
                                                <label class="btn btn-outline-success btn-sm" for="presente_{{ $estudiante->id_usuario }}">
                                                    <i class="fas fa-check me-1"></i>Asistió
                                                </label>

                                                <input type="radio" class="btn-check" name="asistencia[{{ $estudiante->id_usuario }}]" 
                                                       id="tarde_{{ $estudiante->id_usuario }}" value="2" 
                                                       {{ $estudiante->estado_asistencia === 2 ? 'checked' : '' }}>
                                                <label class="btn btn-outline-warning btn-sm" for="tarde_{{ $estudiante->id_usuario }}">
                                                    <i class="fas fa-clock me-1"></i>Llegó Tarde
                                                </label>

                                                <input type="radio" class="btn-check" name="asistencia[{{ $estudiante->id_usuario }}]" 
                                                       id="ausente_{{ $estudiante->id_usuario }}" value="0" 
                                                       {{ $estudiante->estado_asistencia === 0 ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger btn-sm" for="ausente_{{ $estudiante->id_usuario }}">
                                                    <i class="fas fa-times me-1"></i>No Asistió
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($estudiante->asistencia_registrada)
                                                @if($estudiante->estado_asistencia === 1)
                                                    <span class="badge bg-success">Asistió</span>
                                                @elseif($estudiante->estado_asistencia === 2)
                                                    <span class="badge bg-warning">Llegó Tarde</span>
                                                @else
                                                    <span class="badge bg-danger">No Asistió</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Sin registrar</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('asistencias.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>
                            Guardar Asistencias
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @elseif(request('clase_id'))
        <div class="card shadow">
            <div class="card-body text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No hay estudiantes matriculados</h5>
                <p class="text-muted">La clase seleccionada no tiene estudiantes matriculados en el curso correspondiente.</p>
            </div>
        </div>
    @endif
</div>

<script>
function marcarTodos(estado) {
    // estado: 0=Ausente, 1=Presente, 2=Llegó tarde
    const radios = document.querySelectorAll('input[type="radio"]');
    radios.forEach(radio => {
        if (radio.value === estado.toString()) {
            radio.checked = true;
        }
    });
}
</script>

<style>
.btn-check:checked + .btn-outline-success {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}
.btn-check:checked + .btn-outline-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: black;
}
.btn-check:checked + .btn-outline-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}
.table-light {
    background-color: #f8f9fa;
}
</style>
@endsection
