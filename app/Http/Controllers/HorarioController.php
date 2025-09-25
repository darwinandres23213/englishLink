<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class HorarioController extends Controller {
    
    public function index() {
        $horarios = Horario::orderBy('id_horario', 'desc')->paginate(7);
        return view('horarios.index', compact('horarios'));
    }



    public function create() {
        return view('horarios.create', [
            'edit' => false,
        ]);
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'nombre_horario' => 'required|string|max:50',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        Horario::create($validated);
        return redirect()->route('horarios.index')
            ->with('success', 'Horario creado exitosamente.');
    }



    public function show(Horario $horario) {
        return view('horarios.show', compact('horario'));
    }



    public function edit(Horario $horario) {
        return view('horarios.create', [
            'edit' => true,
            'horario' => $horario
        ]);
    }
    public function update(Request $request, Horario $horario) {
        $validated = $request->validate([
            'nombre_horario' => 'required|string|max:50',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $horario->update($validated);
        return redirect()->route('horarios.index')
            ->with('success', 'Horario N° ' . $horario->id_horario . ' actualizado exitosamente.');
    }



    public function destroy(Horario $horario) {
        $nombreHorario = $horario->nombre_horario;
        $horario->delete();
        
        return redirect()->route('horarios.index')
            ->with('success', 'Horario "' . $nombreHorario . '" eliminado exitosamente.');
    }
}