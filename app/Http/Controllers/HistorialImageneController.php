<?php

namespace App\Http\Controllers;

use App\Models\HistorialImagene;
use Illuminate\Http\Request;

class HistorialImageneController extends Controller {
    
    public function index(Request $request) {
        $query = HistorialImagene::query();

        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }
        if ($request->filled('fecha')) {
            $query->whereDate('fecha_subida', $request->fecha);
        }

        $imagenes = $query->latest('id')
            ->paginate(7);
        return view('historial_imagenes.index', compact('imagenes'));
    }



    public function create() {
        return view('historial_imagenes.form');
    }
    public function store(Request $request) {
        $request->validate([
            'usuario_id' => 'required|integer',
            'imagen' => 'required|image|max:2048',
        ]);

        $nombre = $request->file('imagen')->getClientOriginalName();
        $filename = uniqid('historial_') . '_' . $nombre;
        $request->file('imagen')->move(public_path('uploads'), $filename);

        HistorialImagene::create([
            'usuario_id' => $request->usuario_id,
            'nombre_imagen' => $filename, // <-- CAMBIA aquí
            'fecha_subida' => now(),
        ]);

        return redirect()->route('historial_imagenes.index')->with('success', 'Imagen subida correctamente');
    }



    public function edit(HistorialImagene $historial_imagene) {
        return view('historial_imagenes.form', compact('historial_imagene'));
    }
    public function update(Request $request, HistorialImagene $historial_imagene) {
        $request->validate([
            'usuario_id' => 'required|integer',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $data = [
            'usuario_id' => $request->usuario_id,
        ];

        if ($request->hasFile('imagen')) {
            $nombre = $request->file('imagen')->getClientOriginalName();
            $filename = uniqid('historial_') . '_' . $nombre;
            $request->file('imagen')->move(public_path('uploads'), $filename);
            $data['nombre_imagen'] = $filename; // <-- CAMBIA aquí
            $data['fecha_subida'] = now();
        }

        $historial_imagene->update($data);
        return redirect()->route('historial_imagenes.index')->with('success', 'Imagen actualizada correctamente');
    }



    public function destroy(HistorialImagene $historial_imagene) {
        $historial_imagene->delete();
        return back()->with('success', 'Imagen eliminada');
    }
}