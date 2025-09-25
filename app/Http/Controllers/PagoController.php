<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Matricula;
use App\Models\Usuario;
use App\Models\MediosPago;
use App\Models\Estado;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PagoExportExcel;

class PagoController extends Controller{
    public function index(Request $request){
        $query = Pago::with(['matricula.curso', 'matricula.estudiante', 'estadoPago', 'medioPago']);

        // Filtros de búsqueda
        if ($request->filled('matricula_id')) {
            $query->where('matricula_id', $request->matricula_id);
        }
        if ($request->filled('estudiante')) {
            $query->whereHas('matricula.estudiante', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->estudiante . '%');
            });
        }
        if ($request->filled('curso')) {
            $query->whereHas('matricula.curso', function($q) use ($request) {
                $q->where('nombre_curso', 'like', '%' . $request->curso . '%');
            });
        }
        if ($request->filled('estado')) {
            $query->where('estado_pago_id', $request->estado);
        }
        if ($request->filled('medio_pago')) {
            $query->where('medio_pago_id', $request->medio_pago);
        }

        // Filtros de fecha
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_pago', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_pago', '<=', $request->fecha_fin);
        }

        $pagos = $query->latest('id_pago')
            ->paginate(7)
            ->onEachSide(3)
            ->appends($request->all());


        // Para los selects del filtro
        $estados = Estado::porTipo('Pago');
        /*$estados = Estado::whereHas('tipoEstado', function($q) {
            $q->where('nombre_tipo_estado', 'Pago');
        })->get();*/
        //$estados = Estado::where('tipo_estado_id', 4)->get(); // 4 es el ID del tipo de estado 'Pago'
        $medios = MediosPago::with('estado')->orderBy('nombre')->get();
        /*$medios = MediosPago::whereHas('estado', function($q) {
            $q->where('nombre_estado', 'Activo');
        })->get();*/

        //dd($request->all(), $pagos->pluck('medio_pago_id'));
        return view('pagos.index', compact('pagos', 'estados', 'medios'));
    }



    public function create(){
        return view('pagos.create', [
            'pago' => new Pago(),
            'matriculas' => Matricula::with(['estudiante', 'curso'])->get(),
            'estudiantes' => Usuario::all(),
            'medios' => MediosPago::activos()->get(),
            /*'medios' => MediosPago::whereHas('estado', function($q) {
                $q->where('nombre_estado', 'Activo');
            })->get(),*/
            'estados' => Estado::porTipo('Pago'),
            /*'estados' => Estado::whereHas('tipoEstado', function($q) {
                $q->where('nombre_tipo_estado', 'Pago');
            })->get(),*/
            'edit' => false,
        ]);
    }
    public function store(Request $request){
        $validated = $request->validate([
            'matricula_id' => 'required|exists:matriculas,id_matricula',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'estado_pago_id' => 'required|exists:estados,id_estado',
            'medio_pago_id' => 'required|exists:medios_pagos,id_medio_pago',
        ]);

        // Obtener el estudiante_id de la matrícula seleccionada
        //$matricula = Matricula::find($request->matricula_id);
        //$validated['estudiante_id'] = $matricula->estudiante_id;

        Pago::create($validated);
        return redirect()->route('pagos.index')->with('success', 'Pago creado exitosamente!');
    }



    public function edit(Pago $pago){
        return view('pagos.create', [
            'pago' => $pago,
            'matriculas' => Matricula::with(['estudiante', 'curso'])->get(),
            'estudiantes' => Usuario::all(),
            'medios' => MediosPago::activos()->get(),
            /*'medios' => MediosPago::whereHas('estado', function($q) {
                $q->where('nombre_estado', 'Activo');
            })->get(),*/
            'estados' => Estado::porTipo('Pago'),
            /*'estados' => Estado::whereHas('tipoEstado', function($q) {
                $q->where('nombre_tipo_estado', 'Pago');
            })->get(),*/
            'edit' => true,
        ]);
    }
    public function update(Request $request, Pago $pago){
        $validated = $request->validate([
            'matricula_id' => 'required|exists:matriculas,id_matricula',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'estado_pago_id' => 'required|exists:estados,id_estado',
            'medio_pago_id' => 'required|exists:medios_pagos,id_medio_pago',
        ]);

        // Obtener el estudiante_id de la matrícula seleccionada
        //$matricula = Matricula::find($request->matricula_id);
        //$validated['estudiante_id'] = $matricula->estudiante_id;

        $pago->update($validated);
        return redirect()->route('pagos.index')->with('success', 'Pago N° ' . $pago->id_pago . ' actualizado exitosamente!');
    }



    public function destroy(Pago $pago){
        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago N° ' . $pago->id_pago . ' eliminado exitosamente.');
    }




    public function exportPdf(Request $request){
        // Aplica los mismos filtros que en index
        $query = Pago::with(['matricula.estudiante', 'matricula.curso', 'medioPago', 'estadoPago']);

        if ($request->filled('matricula_id')) {
            $query->where('matricula_id', $request->matricula_id);
        }
        if ($request->filled('estudiante')) {
            $query->whereHas('matricula.estudiante', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->estudiante . '%');
            });
        }
        if ($request->filled('curso')) {
            $query->whereHas('matricula.curso', function($q) use ($request) {
                $q->where('nombre_curso', 'like', '%' . $request->curso . '%');
            });
        }
        if ($request->filled('estado')) {
            $query->where('estado_pago_id', $request->estado);
        }
        if ($request->filled('medio_pago')) {
            $query->where('medio_pago_id', $request->medio_pago);
        }
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_pago', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_pago', '<=', $request->fecha_fin);
        }

        $pagos = $query->get();

        $pdf = Pdf::loadView('pagos.export_pdf', compact('pagos'));
        return $pdf->download('pagos.pdf');
    }




    // Exportar pagos a Excel
    public function exportExcel(Request $request) {
        return Excel::download(
            new PagoExportExcel($request),
            'pagos.xlsx'
        );
    }



    
    // Mostrar comprobante en vista HTML antes de descargar PDF
    public function showComprobante(Pago $pago) {
        $pago->load(['matricula.estudiante', 'matricula.curso', 'medioPago', 'estadoPago']);
        return view('pagos.comprobante', compact('pago'));
    }
}