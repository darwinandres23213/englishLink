<?php

namespace App\Http\Controllers;

use App\Models\TiposEstado;
use Illuminate\Http\Request;

class TiposEstadoController extends Controller {
    public function index() {
        $tipos_estados = TiposEstado::latest('id_tipo_estado')
            ->paginate(7);
        return view('tipos_estados.index', compact('tipos_estados'));
    }



    public function create() {
        $edit = false;
        $tipo = new TiposEstado();
        return view('tipos_estados.create', compact('edit', 'tipo'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nombre_tipo_estado' => 'required|string|max:50|unique:tipos_estados,nombre_tipo_estado',
        ]);
        TiposEstado::create($validated);
        return redirect()->route('tipos_estados.index')->with('success', 'Tipo de estado creado correctamente.');
    }



    public function edit(TiposEstado $tipo) {
        $edit = true;
        return view('tipos_estados.create', compact('edit', 'tipo'));
    }
    public function update(Request $request, TiposEstado $tipo) {
        $validated = $request->validate([
            'nombre_tipo_estado' => 'required|string|max:50|unique:tipos_estados,nombre_tipo_estado,' . $tipo->id_tipo_estado . ',id_tipo_estado',
        ]);
        $tipo->update($validated);
        return redirect()->route('tipos_estados.index')->with('success', 'Tipo de estado actualizado correctamente.');
    }

    

    public function destroy(TiposEstado $tipo) {
        $tipo->delete();
        return redirect()->route('tipos_estados.index')->with('success', 'Tipo de estado eliminado correctamente.');
    }
}