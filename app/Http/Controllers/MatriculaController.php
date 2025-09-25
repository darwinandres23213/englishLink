<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Usuario;
use App\Models\Curso;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function index()
    {
        $matriculas = Matricula::with(['estudiante', 'curso'])
            ->latest('id_matricula')
            ->paginate(6);
        return view('matriculas.index', compact('matriculas'));
    }

    public function create()
    {
        $edit = false;
        $matricula = new Matricula();
        
        // Filtrar solo estudiantes (asumiendo que tienen rol de estudiante)
        $estudiantes = Usuario::whereHas('rol', function($query) {
                $query->where('nombre_rol', 'Estudiante');
            })
            ->orderBy('nombre')
            ->orderBy('apellido')
            ->get();
            
        $cursos = Curso::with(['nivel', 'profesor'])
            ->orderBy('nombre_curso')
            ->get();
            
        return view('matriculas.create', compact('edit', 'matricula', 'estudiantes', 'cursos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:usuarios,id_usuario',
            'curso_id' => 'required|exists:cursos,id_curso',
            'fecha_matricula' => 'required|date|before_or_equal:today',
        ], [
            'fecha_matricula.before_or_equal' => 'La fecha de matrícula no puede ser posterior a la fecha actual.',
        ]);

        // Verificar si el estudiante ya está matriculado en este curso
        $matriculaExistente = Matricula::where('estudiante_id', $validated['estudiante_id'])
            ->where('curso_id', $validated['curso_id'])
            ->first();

        if ($matriculaExistente) {
            return back()->withErrors([
                'estudiante_id' => 'Este estudiante ya está matriculado en el curso seleccionado.'
            ])->withInput();
        }

        Matricula::create($validated);
        return redirect()->route('matriculas.index')->with('success', 'Matrícula creada correctamente.');
    }

    public function edit(Matricula $matricula)
    {
        $edit = true;
        
        // Filtrar solo estudiantes (asumiendo que tienen rol de estudiante)
        $estudiantes = Usuario::whereHas('rol', function($query) {
                $query->where('nombre_rol', 'Estudiante');
            })
            ->orderBy('nombre')
            ->orderBy('apellido')
            ->get();
            
        $cursos = Curso::with(['nivel', 'profesor'])
            ->orderBy('nombre_curso')
            ->get();
            
        return view('matriculas.create', compact('edit', 'matricula', 'estudiantes', 'cursos'));
    }

    public function update(Request $request, Matricula $matricula)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:usuarios,id_usuario',
            'curso_id' => 'required|exists:cursos,id_curso',
            'fecha_matricula' => 'required|date|before_or_equal:today',
        ], [
            'fecha_matricula.before_or_equal' => 'La fecha de matrícula no puede ser posterior a la fecha actual.',
        ]);

        // Verificar si el estudiante ya está matriculado en este curso (excluyendo la matrícula actual)
        $matriculaExistente = Matricula::where('estudiante_id', $validated['estudiante_id'])
            ->where('curso_id', $validated['curso_id'])
            ->where('id_matricula', '!=', $matricula->id_matricula)
            ->first();

        if ($matriculaExistente) {
            return back()->withErrors([
                'estudiante_id' => 'Este estudiante ya está matriculado en el curso seleccionado.'
            ])->withInput();
        }

        $matricula->update($validated);
        return redirect()->route('matriculas.index')->with('success', 'Matrícula actualizada correctamente.');
    }

    public function destroy(Matricula $matricula)
    {
        $matricula->delete();
        return redirect()->route('matriculas.index')->with('success', 'Matrícula eliminada correctamente.');
    }
}