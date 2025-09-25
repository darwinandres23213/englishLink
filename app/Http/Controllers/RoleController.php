<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller {

    public function index(Request $request) {
        $query = Role::query();

        if ($request->filled('nombre_rol')) {
            $query->where('nombre_rol', 'like', '%' . $request->nombre_rol . '%');
        }

        $roles = $query->latest('id_rol')
            ->paginate(7);
        return view('roles.index', compact('roles'));
    }

    public function create() {
        $edit = false;
        $rol = null;
        return view('roles.create', compact('edit', 'rol'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nombre_rol' => 'required|string|max:50|unique:roles,nombre_rol',
        ]);
        Role::create($validated);
        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function show(Role $role) {
        return view('roles.show', compact('role'));
    }

    public function edit(Role $rol) {
        $edit = true;
        return view('roles.create', compact('edit', 'rol'));
    }

    public function update(Request $request, Role $rol) {
        $validated = $request->validate([
            'nombre_rol' => 'required|string|max:50|unique:roles,nombre_rol,' . $rol->id_rol . ',id_rol',
        ]);
        $rol->update($validated);
        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Role $rol) {
        $rol->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}

/*class RoleController extends Controller {
    public function index() {
        //
    }

    
    public function create() {
        //
    }

    
    public function store(Request $request) {
        //
    }

    
    public function show(Role $role) {
        //
    }

    
    public function edit(Role $role) {
        //
    }

    
    public function update(Request $request, Role $role) {
        //
    }

    
    public function destroy(Role $role) {
        //
    }
}*/