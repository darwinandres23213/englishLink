{{-- filepath: resources/views/errors/403.blade.php --}}
@extends('layouts.AreaInterna.app')

@section('title', 'Acceso Denegado')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center">
                <div class="error mx-auto" data-text="403">403</div>
                <p class="lead text-gray-800 mb-5">Acceso Denegado</p>
                <p class="text-gray-500 mb-0">No tienes permisos para acceder a esta página.</p>
                <div class="mt-4">
                    <a href="{{ Auth::user()->getDashboardRoute() }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver a mi Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error {
    font-size: 7rem;
    position: relative;
    line-height: 1;
    width: 12.5rem;
}

.error::before {
    content: attr(data-text);
    position: absolute;
    left: 0;
    top: 0;
    color: #eee;
    width: 100%;
    overflow: hidden;
    font-weight: 900;
}
</style>
@endsection
