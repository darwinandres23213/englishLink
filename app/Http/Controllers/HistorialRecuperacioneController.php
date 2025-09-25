<?php

namespace App\Http\Controllers;

use App\Models\HistorialRecuperacione;
use App\Models\Recuperacione;
use Illuminate\Http\Request;

class HistorialRecuperacioneController extends Controller
{
    public function index()
    {
        $historiales = HistorialRecuperacione::with('recuperacion')->orderBy('id', 'desc')->paginate(10);
        return view('historial_recuperaciones.index', compact('historiales'));
    }

    public function create()
    {
        $recuperaciones = Recuperacione::all();
        return view('historial_recuperaciones.create', compact('recuperaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_recuperacion' => 'required|exists:recuperaciones,id',
            'nota_anterior' => 'required|numeric|min:0|max:100',
            'nota_nueva' => 'required|numeric|min:0|max:100',
            'fecha_cambio' => 'required|date',
            'modificado_por' => 'required|string',
        ]);
        HistorialRecuperacione::create($request->all());
        return redirect()->route('historial_recuperaciones.index')->with('success', 'Historial registrado correctamente.');
    }

    public function show(HistorialRecuperacione $historialRecuperacione)
    {
        return view('historial_recuperaciones.show', compact('historialRecuperacione'));
    }

    public function edit(HistorialRecuperacione $historialRecuperacione)
    {
        $recuperaciones = Recuperacione::all();
        return view('historial_recuperaciones.create', compact('historialRecuperacione', 'recuperaciones'));
    }

    public function update(Request $request, HistorialRecuperacione $historialRecuperacione)
    {
        $request->validate([
            'id_recuperacion' => 'required|exists:recuperaciones,id',
            'nota_anterior' => 'required|numeric|min:0|max:100',
            'nota_nueva' => 'required|numeric|min:0|max:100',
            'fecha_cambio' => 'required|date',
            'modificado_por' => 'required|string',
        ]);
        $historialRecuperacione->update($request->all());
        return redirect()->route('historial_recuperaciones.index')->with('success', 'Historial actualizado correctamente.');
    }

    public function destroy(HistorialRecuperacione $historialRecuperacione)
    {
        $historialRecuperacione->delete();
        return redirect()->route('historial_recuperaciones.index')->with('success', 'Historial eliminado correctamente.');
    }
}