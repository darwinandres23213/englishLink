@extends('layouts.AreaInterna.app')

@push('styles')
<style>
    @media print { /* Estilos para impresión */
        body * {
            visibility: hidden !important;
        }

        .container, 
        .container * {
            visibility: visible !important;
        }

        .container {
            position: absolute !important;
            left: 50% !important;
            top: 0 !important;
            transform: translateX(-50%) !important;
            width: 600px !important;
            margin: auto auto !important;
            /* padding: 10px !important; */
            font-size: 1.8em !important;
            box-shadow: none !important;
        }

        .d-flex.justify-content-center.gap-2.mt-4 {
            display: none !important;
        }

        h3, h2 {
            font-size: 2rem !important;
        }

        footer, 
        .footer, 
        #footer {
            display: none !important;
        }
    }

    .dato-comprobante { /* Estilos para los datos del comprobante */
        font-weight: normal;
        display: block;
        margin-top: 2px;
        padding-left: 1rem;
    }

    .table-transparent th, 
    .table-transparent td, 
    .table-transparent tr, 
    .table-transparent tbody { /* Estilos para tabla transparente */
        background: transparent !important;
    }
</style>
@endpush

@section('title', 'Comprobante de Pago EnglishLink!')
@section('content')
<div class="container py-4" style="max-width: 400px; margin: auto; background: url('/img/comprobante_pago.png') center center no-repeat; background-size: cover; border-radius: 12px;">
    <h3 class="mb-4 fw-bold text-black">Comprobante de Pago</h3>
    <hr style="border-top: 3px solid #000000; margin: 1rem 0;">
    
    <table class="table table-borderless table-transparent text-center">
        <tbody class="text-start">

            <tr>
                <th colspan="2">Estudiante:
                    <span class="dato-comprobante">
                        {{ $pago->matricula->estudiante->nombre ?? 'N/A' }} {{ $pago->matricula->estudiante->apellido ?? '' }}
                    </span>
                </th>
            </tr>

            <tr>
                <th colspan="2">Curso:
                    <span class="dato-comprobante">{{ $pago->matricula->curso->nombre_curso ?? 'N/A' }}</span>
                </th>
            </tr>

            <tr>
                <th colspan="2">Matrícula:
                    <span class="dato-comprobante">N° {{ $pago->matricula_id }}</span>
                </th>
            </tr>

            <tr>
                <th colspan="2">Monto:
                    <span class="dato-comprobante">$ {{ number_format($pago->monto, 2, ',', '.') }}</span>
                </th>
            </tr>

            <tr>
                <th colspan="2">Medio de Pago:
                    <span class="dato-comprobante">{{ $pago->medioPago->nombre ?? 'N/A' }}</span>
                </th>
            </tr>

            <tr>
                <th colspan="2">Estado:
                    <span class="dato-comprobante">{{ $pago->estadoPago->nombre_estado ?? 'N/A' }}</span>
                </th>
            </tr>

            <tr>
                <th colspan="2">Fecha:
                    <span class="dato-comprobante">
                        @php(\Carbon\Carbon::setLocale('es'))
                        {{ \Carbon\Carbon::parse($pago->fecha_pago)->translatedFormat('d \d\e F \d\e Y') }}
                    </span>
                </th>
            </tr>

            <tr>
                <th colspan="2">Referencia:
                    <span class="dato-comprobante">ID{{ $pago->id_pago ?? 'N/A' }}</span>
                </th>
            </tr>
        </tbody>
    </table>

    <div class="d-flex justify-content-center gap-2 mt-4">
        <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <button type="button" class="btn btn-danger" onclick="window.print()">
            <i class="bi bi-printer"></i> Imprimir
        </button>
        <button type="button" class="btn btn-info" id="descargar-img">
            <i class="bi bi-image"></i> Imagen
        </button>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script>
        document.getElementById('descargar-img').addEventListener('click', function() {
            // Ocultar solo los botones antes de capturar
            var btns = document.querySelectorAll('.d-flex.justify-content-center.gap-2.mt-4 > a, .d-flex.justify-content-center.gap-2.mt-4 > button');
            btns.forEach(function(btn) { btn.style.display = 'none'; });
            html2canvas(document.querySelector('.container')).then(function(canvas) {
                // Volver a mostrar los botones
                btns.forEach(function(btn) { btn.style.display = ''; });
                var link = document.createElement('a');
                link.download = 'comprobante_pago_{{ $pago->id_pago }}.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        });
        </script>
    </div>

</div>
@endsection