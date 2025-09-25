<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\TiposEstado;
use Illuminate\Http\Request;

class EstadoController extends Controller {
    public function index() {
        $estados = Estado::with('tipoEstado')
            ->latest('id_estado')
            ->paginate(7);
        return view('estados.index', compact('estados'));
    }

    public function create()
    {
        $edit = false;
        $estado = new Estado();
        $tipos_estados = TiposEstado::all();
        return view('estados.create', compact('edit', 'estado', 'tipos_estados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_tipo_estado' => 'required|exists:tipos_estados,id_tipo_estado',
            'nombre_estado' => 'required|string|max:50|unique:estados,nombre_estado,NULL,id_estado,id_tipo_estado,' . $request->id_tipo_estado,
        ]);
        Estado::create($validated);
        return redirect()->route('estados.index')->with('success', 'Estado creado correctamente.');
    }

    public function edit(Estado $estado)
    {
        $edit = true;
        $tipos_estados = TiposEstado::all();
        return view('estados.create', compact('edit', 'estado', 'tipos_estados'));
    }

    public function update(Request $request, Estado $estado)
    {
        $validated = $request->validate([
            'id_tipo_estado' => 'required|exists:tipos_estados,id_tipo_estado',
            'nombre_estado' => 'required|string|max:50|unique:estados,nombre_estado,' . $estado->id_estado . ',id_estado,id_tipo_estado,' . $request->id_tipo_estado,
        ]);
        $estado->update($validated);
        return redirect()->route('estados.index')->with('success', 'Estado actualizado correctamente.');
    }

    public function destroy(Estado $estado)
    {
        $estado->delete();
        return redirect()->route('estados.index')->with('success', 'Estado eliminado correctamente.');
    }
}