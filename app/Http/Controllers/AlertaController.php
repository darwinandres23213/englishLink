<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Usuario;
use App\Models\Estado;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
    public function index()
    {
        $alertas = Alerta::with(['usuario', 'estado'])->orderBy('id', 'desc')->paginate(10);
        return view('alertas.index', compact('alertas'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        $estados = Estado::all();
        return view('alertas.create', compact('usuarios', 'estados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id_usuario',
            'hora_alerta' => 'required|date_format:H:i:s',
            'tipo_alerta' => 'required|in:sistema,curso,usuario,urgente,email,sms,push',
            'mensaje' => 'required|string',
            'estado_id' => 'required|exists:estados,id_estado',
            'fecha_creacion' => 'required|date',
        ]);
        Alerta::create($request->all());
        return redirect()->route('alertas.index')->with('success', 'Alerta creada correctamente.');
    }

    public function show(Alerta $alerta)
    {
        return view('alertas.show', compact('alerta'));
    }

    public function edit(Alerta $alerta)
    {
        $usuarios = Usuario::all();
        $estados = Estado::all();
        return view('alertas.create', compact('alerta', 'usuarios', 'estados'));
    }

    public function update(Request $request, Alerta $alerta)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id_usuario',
            'hora_alerta' => 'required|date_format:H:i:s',
            'tipo_alerta' => 'required|in:sistema,curso,usuario,urgente,email,sms,push',
            'mensaje' => 'required|string',
            'estado_id' => 'required|exists:estados,id_estado',
            'fecha_creacion' => 'required|date',
        ]);
        $alerta->update($request->all());
        return redirect()->route('alertas.index')->with('success', 'Alerta actualizada correctamente.');
    }

    public function destroy(Alerta $alerta)
    {
        $alerta->delete();
        return redirect()->route('alertas.index')->with('success', 'Alerta eliminada correctamente.');
    }
}