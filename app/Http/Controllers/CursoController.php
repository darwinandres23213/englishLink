<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Nivele;
use App\Models\Horario;
use App\Models\Usuario;
use App\Models\Role;
use Illuminate\Http\Request;

class CursoController extends Controller {
    
    public function index() {
        $cursos = Curso::with(['nivel', 'horario', 'profesor'])
            ->latest('id_curso')
            ->paginate(6);
        return view('cursos.index', compact('cursos'));
    }

    public function create() {
        return view('cursos.create', [
            'edit' => false,
            'curso' => new Curso(),
            'niveles' => Nivele::all(),
            'horarios' => Horario::all(),
            'profesores' => Usuario::whereHas('rol', function($q) {
                $q->where('nombre_rol', 'Profesor');
            })->get()
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nombre_curso' => 'required|string|max:100|unique:cursos,nombre_curso',
            'descripcion' => 'nullable|string|max:255',
            'nivel_id' => 'required|exists:niveles,id_nivel',
            'horario_id' => 'required|exists:horarios,id_horario',
            'profesor_id' => 'required|exists:usuarios,id_usuario',
        ]);

        Curso::create($validated);
        return redirect()->route('cursos.index')
            ->with('success', 'Curso creado exitosamente.');
    }

    public function edit(Curso $curso) {
        $curso->load(['nivel', 'horario', 'profesor']);
        
        // Obtener el rol de Profesor
        $rolProfesor = Role::where('nombre_rol', 'Profesor')->first();
        
        // Obtener profesores activos
        $profesores = Usuario::where('rol_id', $rolProfesor->id_rol)
            ->with('rol')
            ->get();
        
        return view('cursos.create', [
            'edit' => true,
            'curso' => $curso,
            'niveles' => Nivele::all(),
            'horarios' => Horario::all(),
            'profesores' => $profesores
        ]);
    }

    public function update(Request $request, Curso $curso) {
        $validated = $request->validate([
            'nombre_curso' => 'required|string|max:100|unique:cursos,nombre_curso,' . $curso->id_curso . ',id_curso',
            'descripcion' => 'nullable|string|max:255',
            'nivel_id' => 'required|exists:niveles,id_nivel',
            'horario_id' => 'required|exists:horarios,id_horario',
            'profesor_id' => 'required|exists:usuarios,id_usuario',
        ]);

        $curso->update($validated);
        return redirect()->route('cursos.index')
            ->with('success', 'Curso "' . $curso->nombre_curso . '" actualizado exitosamente.');
    }

    public function destroy(Curso $curso) {
        $nombreCurso = $curso->nombre_curso;
        $curso->delete();
        
        return redirect()->route('cursos.index')
            ->with('success', 'Curso "' . $nombreCurso . '" eliminado exitosamente.');
    }
}