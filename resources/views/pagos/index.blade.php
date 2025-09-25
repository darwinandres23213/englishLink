@extends('layouts.AreaInterna.app')
@section('title', 'Lista de Pagos')
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
    <h1 class="mb-4 fw-bold">Lista de Pagos</h1>

    {{-- Botón para crear un nuevo pago --}}
    <div class="mb-3">
        <a href="{{ route('pagos.create') }}" class="btn btn-primary">Nuevo Pago</a>
    </div>

    {{-- Filtros desplegables --}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-sliders"> Filtros </i>
            </span>
            <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="false" aria-controls="filtrosCollapse">
                <i class="bi bi-funnel">Mostrar/Ocultar</i>
            </button>
        </div>
        
        <div class="collapse{{ (request()->except(['page']) ? ' show' : '') }}" id="filtrosCollapse"> {{-- Cambié para que se muestre si hay filtros activos --}}
            <div class="card-body">
                <form method="GET" action="{{ route('pagos.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label">N° Matrícula</label>
                        <input type="text" name="matricula_id" class="form-control" placeholder="Ej: 4404" value="{{ request('matricula_id') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Estudiante</label>
                        <input type="text" name="estudiante" class="form-control" placeholder="Escriba el nombre del estudiante..." value="{{ request('estudiante') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Curso</label>
                        <input type="text" name="curso" class="form-control" placeholder="Escriba el nombre del curso..." value="{{ request('curso') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="">Todos</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado }}" {{ request('estado') == $estado->id_estado ? 'selected' : '' }}>
                                    {{ $estado->nombre_estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Medio de Pago</label>
                        <select name="medio_pago" class="form-select">
                            <option value="">Todos</option>
                            @foreach($medios as $medio)
                                <option value="{{ $medio->id_medio_pago }}" 
                                        {{ request('medio_pago') == $medio->id_medio_pago ? 'selected' : '' }}
                                        @if($medio->estado && !$medio->isActivo()) style="color: #6c757d; font-style: italic;" @endif>
                                    {{ $medio->nombre }}
                                    @if($medio->estado && !$medio->isActivo())
                                        (Inactivo)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Fecha inicial</label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Fecha final</label>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                    </div>

                    <div class="col-md-6 d-flex gap-1">
                        <button type="submit" class="btn btn-primary mt-4">
                            <i class="bi bi-search"> Buscar</i>
                        </button>
                        <a href="{{ route('pagos.index') }}" class="btn btn-secondary mt-4">
                            <i class="bi bi-x-circle"> Limpiar filtros</i>
                        </a>
                        <a href="{{ route('pagos.export.pdf', request()->all()) }}" class="btn btn-outline-danger mt-4">
                            <i class="bi bi-file-earmark-pdf"> PDF</i>
                        </a>
                        <a href="{{ route('pagos.export.excel', request()->all()) }}" class="btn btn-outline-success mt-4">
                            <i class="bi bi-file-earmark-excel"> Excel</i>
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Tabla de pagos --}}
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="text-center">ID Pago</th>
                    <th class="text-center">N° Matrícula</th>
                    <th>Estudiante</th>
                    <th>Curso</th>
                    <th>Monto</th>
                    <th>Fecha Pago</th>
                    <th>Medio de Pago</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($pagos as $pago)
                    <tr>
                        <td class="text-center">{{ $pago->id_pago }}</td>
                        <td class="text-center">{{ $pago->matricula_id }}</td>
                        <td>{{ $pago->matricula->estudiante->nombre ?? 'N/A' }}</td>
                        <td>{{ $pago->matricula->curso->nombre_curso ?? 'N/A' }}</td>
                        <td>${{ $pago->monto }}</td>
                        <td>{{ $pago->fecha_pago }}</td>
                        <td>{{ $pago->medioPago->nombre ?? 'N/A' }}</td>
                        <td class="text-center"> 
                            {{-- Estado del pago --}}
                            <span class="badge 
                                @switch($pago->estadoPago->nombre_estado ?? '')
                                    @case('Pagado')
                                        bg-success
                                        @break
                                    @case('Pendiente')
                                        bg-warning
                                        @break
                                    @case('Vencido')
                                        bg-danger
                                        @break
                                    @case('Cancelado')
                                        bg-secondary
                                        @break
                                    @default
                                        bg-secondary
                                @endswitch
                            " style="min-width: 80px; display: inline-block; text-align: center;">
                                {{ $pago->estadoPago->nombre_estado ?? 'N/A' }}
                            </span>
                        </td>

                        <td class="text-center">
                            {{-- Botones de acción --}}

                            <a href="{{ route('pago.comprobante', $pago) }}" class="btn btn-sm btn-outline-info" title="Ver comprobante">
                            {{-- <a href="{{ route('pagos.comprobante.html', $pago) }}" class="btn btn-sm btn-outline-info" title="Ver Comprobante" target="_blank"> --}}
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('pagos.edit', $pago) }}" class="btn btn-sm btn-outline-primary" title="Editar pago">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('pagos.destroy', $pago) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este pago?')" title="Eliminar pago">
                                    <i class="bi bi-trash"></i>
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
            {{ $pagos->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection