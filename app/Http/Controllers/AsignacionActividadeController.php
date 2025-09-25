<?php

namespace App\Http\Controllers;

use App\Models\AsignacionActividade;
use App\Models\Usuario;
use App\Models\Curso;
use App\Models\Estado;
use Illuminate\Http\Request;

class AsignacionActividadeController extends Controller{
    
    public function index(Request $request){
        $query = AsignacionActividade::query();

        // Filtro por usuario (nombre)
        if ($request->filled('usuario')) {
            $query->whereHas('usuario', function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->usuario . '%');
            });
        }

        // Filtro por curso (nombre_curso)
        if ($request->filled('curso')) {
            $query->whereHas('curso', function($q) use ($request) {
                $q->where('nombre_curso', 'like', '%' . $request->curso . '%');
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado_id', $request->estado);
        }

        $asignaciones = $query->latest('id')->paginate(10)->onEachSide(3)->appends($request->all());

        // Para el select de estados
        $estados = Estado::all();

        return view('asignacion_actividades.index', compact('asignaciones', 'estados'));
    }

    
    public function create(){
        return view('asignacion_actividades.form', [
            'asignacion' => new AsignacionActividade(),
            'usuarios' => Usuario::all(),
            'cursos' => Curso::all(),
            'estados' => Estado::all(),
            'edit' => false,
        ]);
    }
    public function store(Request $request){
        AsignacionActividade::create($request->all());
        return redirect()->route('asignacion-actividades.index');
    }


    public function edit(AsignacionActividade $asignacion_actividade){
        return view('asignacion_actividades.form', [
            'asignacion' => $asignacion_actividade,
            'usuarios' => Usuario::all(),
            'cursos' => Curso::all(),
            'estados' => Estado::all(),
            'edit' => true,
        ]);
    }
    public function update(Request $request, AsignacionActividade $asignacion_actividade){
        $asignacion_actividade->update($request->all());
        return redirect()->route('asignacion-actividades.index');
    }


    public function destroy(AsignacionActividade $asignacion_actividade){
        $asignacion_actividade->delete();
        return redirect()->route('asignacion-actividades.index');
    }
}
