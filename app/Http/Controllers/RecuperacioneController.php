<?php

namespace App\Http\Controllers;

use App\Models\Recuperacione;
use App\Models\RegistroCalificacione;
use App\Models\Estado;
use Illuminate\Http\Request;

class RecuperacioneController extends Controller
{
    public function index()
    {
        $recuperaciones = Recuperacione::with(['registroCalificacion', 'estado'])->orderBy('id', 'desc')->paginate(10);
        return view('recuperaciones.index', compact('recuperaciones'));
    }

    public function create()
    {
        $calificaciones = RegistroCalificacione::all();
        $estados = Estado::all();
        return view('recuperaciones.create', compact('calificaciones', 'estados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_calificacion' => 'required|exists:registro_calificaciones,id',
            'nota_recuperacion' => 'required|numeric|min:0|max:100',
            'estado_id' => 'required|exists:estados,id_estado',
            'fecha_recuperacion' => 'required|date',
            'creado_por' => 'required|string',
            'actualizado_por' => 'required|string',
            'comentarios' => 'nullable|string',
        ]);
        Recuperacione::create($request->all());
        return redirect()->route('recuperaciones.index')->with('success', 'Recuperación registrada correctamente.');
    }

    public function show(Recuperacione $recuperacione)
    {
        return view('recuperaciones.show', compact('recuperacione'));
    }

    public function edit(Recuperacione $recuperacione)
    {
        $calificaciones = RegistroCalificacione::all();
        $estados = Estado::all();
        return view('recuperaciones.create', compact('recuperacione', 'calificaciones', 'estados'));
    }

    public function update(Request $request, Recuperacione $recuperacione)
    {
        $request->validate([
            'id_calificacion' => 'required|exists:registro_calificaciones,id',
            'nota_recuperacion' => 'required|numeric|min:0|max:100',
            'estado_id' => 'required|exists:estados,id_estado',
            'fecha_recuperacion' => 'required|date',
            'creado_por' => 'required|string',
            'actualizado_por' => 'required|string',
            'comentarios' => 'nullable|string',
        ]);
        $recuperacione->update($request->all());
        return redirect()->route('recuperaciones.index')->with('success', 'Recuperación actualizada correctamente.');
    }

    public function destroy(Recuperacione $recuperacione)
    {
        $recuperacione->delete();
        return redirect()->route('recuperaciones.index')->with('success', 'Recuperación eliminada correctamente.');
    }
}