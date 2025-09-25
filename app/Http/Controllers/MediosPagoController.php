<?php

namespace App\Http\Controllers;

use App\Models\MediosPago;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MediosPagoExport; // Asegúrate de que este export exista
use Maatwebsite\Excel\Facades\Excel; // Asegúrate de que Maatwebsite Excel esté instalado

class MediosPagoController extends Controller{
    
    public function index(Request $request){
        $query = MediosPago::with('estado');
        
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->filled('estado')) {
            $query->where('estado_id', $request->estado);
        }
        $medios = $query->latest('id_medio_pago')
            ->paginate(7)
            ->onEachSide(3)
            ->appends($request->all());

        $estados = Estado::whereHas('tipoEstado', function($q) {
            $q->where('nombre_tipo_estado', 'MedioPago');
        })->get();
        return view('medios_pago.index', compact('medios', 'estados'));

        /*$query = MediosPago::query();
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }

        $medios = $query->latest('id_medio_pago')->paginate(10)->onEachSide(3)->appends($request->all());
        return view('medios_pago.index', compact('medios'));*/
    }


    public function create(){
        $estados = Estado::whereHas('tipoEstado', function($q) {
            $q->where('nombre_tipo_estado', 'MedioPago');
        })->get();

        return view('medios_pago.form_createdit', [
            'medio' => new MediosPago(),
            'estados' => $estados,
            'edit' => false,
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:100|unique:medios_pagos,nombre',
            'descripcion' => 'nullable|string|max:255',
            'estado_id' => 'required|exists:estados,id_estado',
        ]);
        MediosPago::create($request->all());
        return redirect()->route('mediopago.index')->with('success', 'Medio de pago creado exitosamente!');
    }


    public function edit(MediosPago $medio){
        $estados = Estado::whereHas('tipoEstado', function($q) {
            $q->where('nombre_tipo_estado', 'MedioPago');
        })->get();

        return view('medios_pago.form_createdit', [
            'medio' => $medio,
            'estados' => $estados,
            'edit' => true,
        ]);
    }
    public function update(Request $request, MediosPago $medio){
        $request->validate([
            'nombre' => 'required|string|max:100|unique:medios_pagos,nombre,' . $medio->id_medio_pago . ',id_medio_pago',
            'descripcion' => 'nullable|string|max:255',
            'estado_id' => 'required|exists:estados,id_estado',
        ]);
        $medio->update($request->all());
        return redirect()->route('mediopago.index')->with('success', 'Medio de pago actualizado exitosamente!');
    }


    public function destroy(MediosPago $medio){
        try {
            $medio->delete();
            return redirect()->route('mediopago.index')->with('success', 'Medio de pago eliminado correctamente!');
        } catch (QueryException $e) {
            // Código de error 1451 = restricción de clave foránea
            if ($e->getCode() == 23000) {
                return redirect()->route('mediopago.index')
                    ->with('error', 'No se puede eliminar el medio de pago porque está en uso en uno o más pagos.');
            }
            throw $e;
        }
    }




    /*Exportar medios de pago a PDF y Excel.*/
    public function exportPdf(Request $request) {
        $query = MediosPago::with('estado');
        
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->filled('estado')) {
            $query->where('estado_id', $request->estado);
        }
        
        $medios = $query->get();
        $pdf = Pdf::loadView('medios_pago.export_pdf', compact('medios'));
        return $pdf->download('medios_pago.pdf');
    }

    public function exportExcel(Request $request) {
        return Excel::download(new MediosPagoExport($request), 'medios_pago.xlsx');
    }
}