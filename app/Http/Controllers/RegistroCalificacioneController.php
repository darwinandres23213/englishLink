<?php

namespace App\Http\Controllers;

use App\Models\RegistroCalificacione;
use App\Models\Usuario;
use App\Models\Curso;
use App\Models\Estado;
use Illuminate\Http\Request;

class RegistroCalificacioneController extends Controller
{
    public function index()
    {
        $registros = RegistroCalificacione::with(['usuario', 'curso', 'estado'])->orderBy('id', 'desc')->paginate(10);
        return view('registro_calificaciones.index', compact('registros'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        $cursos = Curso::all();
        $estados = Estado::all();
        return view('registro_calificaciones.create', compact('usuarios', 'cursos', 'estados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id_usuario',
            'curso_id' => 'required|exists:cursos,id_curso',
            'calificacion' => 'required|numeric|min:0|max:100',
            'retroalimentacion' => 'nullable|string',
            'fecha_registro' => 'required|date',
            'pendiente_recuperacion' => 'required|boolean',
            'creado_por' => 'required|string',
            'actualizado_por' => 'required|string',
            'estado_id' => 'required|exists:estados,id_estado',
        ]);
        RegistroCalificacione::create($request->all());
        return redirect()->route('registro_calificaciones.index')->with('success', 'Registro de calificación creado correctamente.');
    }

    public function show(RegistroCalificacione $registroCalificacione)
    {
        return view('registro_calificaciones.show', compact('registroCalificacione'));
    }

    public function edit(RegistroCalificacione $registroCalificacione)
    {
        $usuarios = Usuario::all();
        $cursos = Curso::all();
        $estados = Estado::all();
        return view('registro_calificaciones.create', compact('registroCalificacione', 'usuarios', 'cursos', 'estados'));
    }

    public function update(Request $request, RegistroCalificacione $registroCalificacione)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id_usuario',
            'curso_id' => 'required|exists:cursos,id_curso',
            'calificacion' => 'required|numeric|min:0|max:100',
            'retroalimentacion' => 'nullable|string',
            'fecha_registro' => 'required|date',
            'pendiente_recuperacion' => 'required|boolean',
            'creado_por' => 'required|string',
            'actualizado_por' => 'required|string',
            'estado_id' => 'required|exists:estados,id_estado',
        ]);
        $registroCalificacione->update($request->all());
        return redirect()->route('registro_calificaciones.index')->with('success', 'Registro de calificación actualizado correctamente.');
    }

    public function destroy(RegistroCalificacione $registroCalificacione)
    {
        $registroCalificacione->delete();
        return redirect()->route('registro_calificaciones.index')->with('success', 'Registro de calificación eliminado correctamente.');
    }
}