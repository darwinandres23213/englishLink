<?php

namespace App\Http\Controllers;

use App\Models\Notificacione;
use App\Models\Usuario;
use App\Models\Estado;
use Illuminate\Http\Request;

class NotificacioneController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacione::with(['usuario', 'estado'])->orderBy('id', 'desc')->paginate(10);
        return view('notificaciones.index', compact('notificaciones'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        $estados = Estado::all();
        return view('notificaciones.create', compact('usuarios', 'estados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id_usuario',
            'mensaje' => 'required|string|max:1000',
            'estado_id' => 'required|exists:estados,id_estado',
            'tipo' => 'required|in:Sistema,Curso,Usuario',
            'fecha_envio' => 'nullable|date',
        ]);
        Notificacione::create($request->all());
        return redirect()->route('notificaciones.index')->with('success', 'Notificación creada correctamente.');
    }

    public function show(Notificacione $notificacione)
    {
        return view('notificaciones.show', compact('notificacione'));
    }

    public function edit(Notificacione $notificacione)
    {
        $usuarios = Usuario::all();
        $estados = Estado::all();
        return view('notificaciones.create', compact('notificacione', 'usuarios', 'estados'));
    }

    public function update(Request $request, Notificacione $notificacione)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id_usuario',
            'mensaje' => 'required|string|max:1000',
            'estado_id' => 'required|exists:estados,id_estado',
            'tipo' => 'required|in:Sistema,Curso,Usuario',
            'fecha_envio' => 'nullable|date',
        ]);
        $notificacione->update($request->all());
        return redirect()->route('notificaciones.index')->with('success', 'Notificación actualizada correctamente.');
    }

    public function destroy(Notificacione $notificacione)
    {
        $notificacione->delete();
        return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminada correctamente.');
    }
}