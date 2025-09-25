<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Role;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller {
    public function index(Request $request) {
        $query = Usuario::with(['rol', 'estado']);

        // Filtros de búsqueda
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->filled('apellido')) {
            $query->where('apellido', 'like', '%' . $request->apellido . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('rol')) {
            $query->where('rol_id', $request->rol);
        }
        if ($request->filled('estado')) {
            $query->where('estado_id', $request->estado);
        }

        $usuarios = $query->latest('id_usuario')
            ->paginate(7)
            ->appends($request->all());

        // Para los selects del filtro
        $roles = Role::all();
        $estados = Estado::porTipo('Usuario');
        
        return view('usuarios.index', compact('usuarios', 'roles', 'estados'));
    }

    public function create() {
        $roles = Role::all();
        $estados = Estado::porTipo('Usuario');
        $usuario = new Usuario();
        $edit = false;
        return view('usuarios.create', compact('roles', 'estados', 'usuario', 'edit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:usuarios,email',
            'contrasena' => 'required|string|min:6',
            'rol_id' => 'required|exists:roles,id_rol',
            'estado_id' => 'required|exists:estados,id_estado',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $validated['contrasena'] = Hash::make($validated['contrasena']);

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $validated['imagen'] = $filename;
        }

        Usuario::create($validated);
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function show(Usuario $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        $roles = Role::all();
        $estados = Estado::porTipo('Usuario');
        $edit = true;
        return view('usuarios.create', compact('roles', 'estados', 'usuario', 'edit'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:usuarios,email,' . $usuario->id_usuario . ',id_usuario',
            'rol_id' => 'required|exists:roles,id_rol',
            'estado_id' => 'required|exists:estados,id_estado',
            'imagen' => 'nullable|image|max:2048',
        ]);

        // Manejo de imagen
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $validated['imagen'] = $filename;
        }

        $usuario->update($validated);
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        if ($usuario->imagen && file_exists(public_path('uploads/' . $usuario->imagen))) {
            unlink(public_path('uploads/' . $usuario->imagen));
        }
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}