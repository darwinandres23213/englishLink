{{-- filepath: resources/views/medios_pago/form_createdit.blade.php --}}
@extends('layouts.AreaInterna.app')

@section('title', $edit ? 'Editar Medio de Pago' : 'Nuevo Medio de Pago')

@section('content')
<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ $edit ? 'Editar Medio de Pago' : 'Nuevo Medio de Pago' }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $edit ? route('mediopago.update', $medio) : route('mediopago.store') }}">
                        @csrf
                        @if($edit)
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   value="{{ old('nombre', $medio->nombre) }}" 
                                   placeholder="Ej: Tarjeta de Crédito, PayPal, Efectivo..."
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" 
                                      id="descripcion" 
                                      class="form-control @error('descripcion') is-invalid @enderror" 
                                      rows="3"
                                      placeholder="Describe brevemente este medio de pago...">{{ old('descripcion', $medio->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> 
                                Información adicional sobre este medio de pago (opcional)
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="estado_id" class="form-label">Estado <span class="text-danger">*</span></label>
                            <select name="estado_id" 
                                    id="estado_id" 
                                    class="form-select @error('estado_id') is-invalid @enderror" 
                                    required>
                                <option value="">Seleccione un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado }}" 
                                            {{ old('estado_id', $medio->estado_id) == $estado->id_estado ? 'selected' : '' }}>
                                        <i class="bi {{ $estado->nombre_estado === 'Activo' ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                        {{ $estado->nombre_estado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-lightbulb"></i> 
                                Los medios <strong>Activos</strong> aparecerán disponibles para nuevos pagos
                            </div>
                        </div>

                        {{-- Información adicional --}}
                        @if($edit && $medio->id_medio_pago)
                            <div class="mb-3 p-3 bg-light rounded">
                                <h6 class="mb-2 text-muted">
                                    <i class="bi bi-info-circle"></i> Información del Medio de Pago
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">ID:</small>
                                        <strong>#{{ $medio->id_medio_pago }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Creado:</small>
                                        <strong>{{ $medio->created_at?->format('d/m/Y') ?? 'N/A' }}</strong>
                                    </div>
                                </div>
                                @if($medio->estado && !$medio->isActivo())
                                    <div class="mt-2">
                                        <div class="alert alert-warning mb-0 py-2">
                                            <i class="bi bi-exclamation-triangle"></i>
                                            <small>
                                                Este medio está <strong>inactivo</strong> y no aparecerá en nuevos pagos, 
                                                pero se mantiene para el historial.
                                            </small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('mediopago.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> {{ $edit ? 'Actualizar' : 'Crear' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript para mejorar la UX --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-focus en el campo nombre
        const nombreInput = document.getElementById('nombre');
        if (nombreInput && !nombreInput.value) {
            nombreInput.focus();
        }

        // Validación en tiempo real del nombre
        nombreInput?.addEventListener('input', function() {
            const value = this.value.trim();
            if (value.length > 0 && value.length < 3) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });

        // Contador de caracteres para descripción
        const descripcionTextarea = document.getElementById('descripcion');
        if (descripcionTextarea) {
            const maxLength = 255;
            const counter = document.createElement('small');
            counter.className = 'form-text text-muted';
            counter.style.textAlign = 'right';
            counter.style.display = 'block';
            
            const updateCounter = () => {
                const remaining = maxLength - descripcionTextarea.value.length;
                counter.textContent = `${descripcionTextarea.value.length}/${maxLength} caracteres`;
                counter.style.color = remaining < 20 ? '#dc3545' : '#6c757d';
            };
            
            descripcionTextarea.addEventListener('input', updateCounter);
            descripcionTextarea.parentNode.appendChild(counter);
            updateCounter();
        }

        // Validación del formulario antes de enviar
        const form = document.querySelector('form');
        form?.addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombre').value.trim();
            const estado = document.getElementById('estado_id').value;
            
            if (!nombre || nombre.length < 3) {
                e.preventDefault();
                alert('El nombre debe tener al menos 3 caracteres');
                document.getElementById('nombre').focus();
                return false;
            }
            
            if (!estado) {
                e.preventDefault();
                alert('Debe seleccionar un estado');
                document.getElementById('estado_id').focus();
                return false;
            }
            
            // Confirmación para cambios importantes
            @if($edit)
                if (confirm('¿Está seguro de actualizar este medio de pago?')) {
                    return true;
                } else {
                    e.preventDefault();
                    return false;
                }
            @endif
        });
    });
</script>
@endsection