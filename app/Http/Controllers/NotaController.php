<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index()
    {
        $notas = Nota::all();
        return view('notas.index', compact('notas'));
    }

    public function create()
    {
        return view('notas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'evaluacion_id' => 'required|integer',
            'estudiante_id' => 'required|integer',
            'calificacion' => 'required|numeric|min:0|max:100',
        ]);

        Nota::create($request->all());
        return redirect()->route('notas.index')->with('success', 'Nota creada correctamente.');
    }

    public function show(Nota $nota)
    {
        return view('notas.show', compact('nota'));
    }

    public function edit(Nota $nota)
    {
        return view('notas.edit', compact('nota'));
    }

    public function update(Request $request, Nota $nota)
    {
        $request->validate([
            'evaluacion_id' => 'required|integer',
            'estudiante_id' => 'required|integer',
            'calificacion' => 'required|numeric|min:0|max:100',
        ]);

        $nota->update($request->all());
        return redirect()->route('notas.index')->with('success', 'Nota actualizada correctamente.');
    }

    public function destroy(Nota $nota)
    {
        $nota->delete();
        return redirect()->route('notas.index')->with('success', 'Nota eliminada correctamente.');
    }
}