<?php

namespace App\Http\Controllers;

use App\Models\Evaluacione;
use App\Models\Curso;
use Illuminate\Http\Request;

class EvaluacioneController extends Controller
{
    public function index()
    {
        $evaluaciones = Evaluacione::with('curso')->paginate(10);
        return view('evaluaciones.index', compact('evaluaciones'));
    }

    public function create()
    {
        $cursos = Curso::all();
        return view('evaluaciones.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id_curso',
            'titulo' => 'required|string|max:255',
        ]);
        Evaluacione::create($request->all());
        return redirect()->route('evaluaciones.index')->with('success', 'Evaluación creada correctamente.');
    }

    public function show(Evaluacione $evaluacione)
    {
        return view('evaluaciones.show', compact('evaluacione'));
    }

    public function edit(Evaluacione $evaluacione)
    {
        $cursos = Curso::all();
        return view('evaluaciones.edit', compact('evaluacione', 'cursos'));
    }

    public function update(Request $request, Evaluacione $evaluacione)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id_curso',
            'titulo' => 'required|string|max:255',
        ]);
        $evaluacione->update($request->all());
        return redirect()->route('evaluaciones.index')->with('success', 'Evaluación actualizada correctamente.');
    }

    public function destroy(Evaluacione $evaluacione)
    {
        $evaluacione->delete();
        return redirect()->route('evaluaciones.index')->with('success', 'Evaluación eliminada correctamente.');
    }
}