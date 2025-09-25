{{-- filepath: resources/views/medios_pago/index.blade.php --}}
@extends('layouts.AreaInterna.app')

@section('title', 'Medios de Pago')

@section('content')

@if(session('success'))
    <div id="toast-success"
        style="
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            min-width: 340px;
            max-width: 400px;
            background: #b7eac7;
            color: #155724;
            border-radius: 12px;
            box-shadow: 0 4px 24px #0002;
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

<div class="container py-4">
    <h1 class="mb-4 fw-bold">Medios de Pago</h1>

    {{-- Botón para crear nuevo medio de pago --}}
    <div class="mb-3">
        <a href="{{ route('mediopago.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"> Nuevo Medio de Pago</i>
        </a>
    </div>

    {{-- Filtros avanzados --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-sliders"> Filtros </i>
            </span>
            <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="{{ (request()->except(['page']) ? 'true' : 'false') }}" aria-controls="filtrosCollapse">
                <i class="bi bi-funnel">Mostrar/Ocultar</i>
            </button>
        </div>
        <div class="collapse{{ (request()->except(['page']) ? ' show' : '') }}" id="filtrosCollapse">
            <div class="card-body">
                <form method="GET" action="{{ route('mediopago.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-select">
                            <option value="">-- Todos --</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado }}" {{ request('estado') == $estado->id_estado ? 'selected' : '' }}>
                                    {{ $estado->nombre_estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-1">
                        <button type="submit" class="btn btn-primary mt-4"><i class="bi bi-funnel"></i> Buscar</button>
                        <a href="{{ route('mediopago.index') }}" class="btn btn-secondary mt-4"><i class="bi bi-x-circle"></i> Limpiar filtros</a>
                        <a href="{{ route('mediopago.export.pdf', request()->all()) }}" class="btn btn-danger mt-4"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
                        <a href="{{ route('mediopago.export.excel', request()->all()) }}" class="btn btn-success mt-4"><i class="bi bi-file-earmark-excel"></i> Excel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabla de medios de pago --}}
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th class="text-nowrap text-center" style="width: 140px;">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($medios as $medio)
                    <tr class="clase-item">
                        <td>{{ $medio->id_medio_pago ?? $medio->id }}</td>
                        <td>
                            <strong>{{ $medio->nombre }}</strong>
                            {{-- Indicar si el medio está inactivo --}}
                            @if($medio->estado && !$medio->isActivo())
                                <small class="text-muted d-block">
                                    <i class="bi bi-info-circle"></i> Ya no disponible para nuevos pagos
                                </small>
                            @endif
                        </td>
                        <td>{{ $medio->descripcion ?? 'Sin descripción' }}</td>
                        <td>
                            {{-- Estado --}}
                            <span class="badge 
                            {{ $medio->estado && $medio->estado->nombre_estado === 'Activo' ? 'bg-success' : 'bg-secondary' }}" 
                                 style="min-width: 80px; display: inline-block; text-align: center;">
                                <i class="bi {{ $medio->estado && $medio->estado->nombre_estado === 'Activo' ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                {{ $medio->estado->nombre_estado ?? 'N/A' }}
                            </span>
                        </td>

                        <td class="d-flex gap-2 text-nowrap justify-content-center">
                            <a href="{{ route('mediopago.edit', $medio->id_medio_pago) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil" title="Editar medio de pago"></i>
                            </a>
                            <form action="{{ route('mediopago.destroy', $medio->id_medio_pago) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este medio de pago?')">
                                    <i class="bi bi-trash" title="Eliminar medio de pago"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-info-circle"></i> No hay medios de pago disponibles y/o no hay resultados para los filtros aplicados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="row mt-3">
        <div class="col-md-12 text-end">
            {{ $medios->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- FILTRO EN TIEMPO REAL --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $("input[name='nombre']").on("keyup", function () {
        var valor = $(this).val().toLowerCase();
        $(".clase-item").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1);
        });
    });
});
</script>
@endsection