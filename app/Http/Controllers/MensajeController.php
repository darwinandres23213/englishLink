<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Usuario;
use Illuminate\Http\Request;

class MensajeController extends Controller {

    public function index() {
        $mensajes = Mensaje::with(['remitente', 'destinatario'])->orderByDesc('fecha_envio')->paginate(10);
        return view('mensajes.index', compact('mensajes'));
    }

    public function create() {
        $usuarios = Usuario::all();
        return view('mensajes.create', compact('usuarios'));
    }

    public function store(Request $request) {

        $validated = $request->validate([
            'remitente_id' => 'required|exists:usuarios,id_usuario',
            'destinatario_id' => 'required|exists:usuarios,id_usuario',
            'contenido' => 'required|string|max:1000',
        ]);
        $validated['fecha_envio'] = now();
        $validated['leido'] = false;
        $validated['tiene_adjuntos'] = false;

        Mensaje::create($validated);
        return redirect()->route('mensajes.index')->with('success', 'Mensaje enviado correctamente.');
    }

    public function show(Mensaje $mensaje)
    {
        return view('mensajes.show', compact('mensaje'));
    }

    public function edit(Mensaje $mensaje)
    {
        $usuarios = Usuario::all();
        return view('mensajes.edit', compact('mensaje', 'usuarios'));
    }

    public function update(Request $request, Mensaje $mensaje)
    {
        $validated = $request->validate([
            'contenido' => 'required|string|max:1000',
        ]);
        $mensaje->update($validated);
        return redirect()->route('mensajes.index')->with('success', 'Mensaje actualizado correctamente.');
    }

    public function destroy(Mensaje $mensaje)
    {
        $mensaje->delete();
        return redirect()->route('mensajes.index')->with('success', 'Mensaje eliminado correctamente.');
    }
}