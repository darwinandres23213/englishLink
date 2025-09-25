<?php

namespace App\Http\Controllers;

use App\Models\Nivele;
use Illuminate\Http\Request;

class NiveleController extends Controller {
    
    public function index() {
        $niveles = Nivele::latest('id_nivel')
            ->paginate(7);
        return view('niveles.index', compact('niveles'));
    }

    public function create()
    {
        $edit = false;
        $nivel = new Nivele();
        return view('niveles.create', compact('edit', 'nivel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_nivel' => 'required|string|max:50|unique:niveles,nombre_nivel',
        ]);
        Nivele::create($validated);
        return redirect()->route('niveles.index')->with('success', 'Nivel creado correctamente.');
    }

    public function edit(Nivele $nivel)
    {
        $edit = true;
        return view('niveles.create', compact('edit', 'nivel'));
    }

    public function update(Request $request, Nivele $nivel)
    {
        $validated = $request->validate([
            'nombre_nivel' => 'required|string|max:50|unique:niveles,nombre_nivel,' . $nivel->id_nivel . ',id_nivel',
        ]);
        $nivel->update($validated);
        return redirect()->route('niveles.index')->with('success', 'Nivel actualizado correctamente.');
    }

    public function destroy(Nivele $nivel)
    {
        $nivel->delete();
        return redirect()->route('niveles.index')->with('success', 'Nivel eliminado correctamente.');
    }
}