<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\HistorialImagene;

class ProfileController extends Controller {
    // Quitar imagen de perfil y volver a estado por defecto
    public function removeProfileImage(Request $request)
    {
        $usuario = Auth::user();
        if ($usuario->imagen) {
            $usuario->imagen = null;
            $usuario->save();
            return redirect()->route('profile')->with('success', 'Imagen de perfil quitada.');
        }
        return redirect()->route('profile')->with('success', 'No tenías imagen de perfil para quitar.');
    }
    // Usar imagen del historial como foto de perfil
    public function useImageFromHistorial(Request $request)
    {
        $usuario = Auth::user();
        $imagen = $request->input('imagen_historial');

        // Verifica que la imagen exista en el historial del usuario
        $existe = $usuario->historialImagenes()->where('nombre_imagen', $imagen)->exists();
        if ($existe) {
            // Borra la imagen anterior si no es la predeterminada y es diferente a la nueva
            if ($usuario->imagen && $usuario->imagen !== 'UsuarioSinPerfil.png' && $usuario->imagen !== $imagen) {
                // No borrar el archivo físico, solo desvincular
                $usuario->imagen = null;
            }
            $usuario->imagen = $imagen;
            $usuario->save();
            return redirect()->route('profile')->with('success', 'Imagen de historial usada como foto de perfil.');
        }
        return redirect()->route('profile')->with('error', 'La imagen seleccionada no existe en tu historial.');
    }
    public function show() {
        $usuario = Auth::user();
        $historialImagenes = $usuario->historialImagenes()->orderByDesc('fecha_subida')->get();

        // Si tienes relaciones para cursos o historial, puedes agregarlas aquí después
        // $cursos = $usuario->cursos; // Ejemplo si tienes relación definida
        // $historialImagenes = $usuario->historialImagenes;

        return view('profile', compact('usuario', 'historialImagenes'));
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $usuario = Auth::user();

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = uniqid('perfil_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);

            // Registrar la imagen anterior en el historial si no es la predeterminada y no está ya registrada
            if ($usuario->imagen && $usuario->imagen !== 'UsuarioSinPerfil.png') {
                $yaRegistrada = HistorialImagene::where('usuario_id', $usuario->id_usuario ?? $usuario->id)
                    ->where('nombre_imagen', $usuario->imagen)->exists();
                if (!$yaRegistrada) {
                    HistorialImagene::create([
                        'usuario_id' => $usuario->id_usuario ?? $usuario->id,
                        'nombre_imagen' => $usuario->imagen,
                        'fecha_subida' => now(),
                    ]);
                }
                // No eliminar el archivo físico, solo desvincular
            }

            $usuario->imagen = $filename;
            $usuario->save();

            // Registrar la nueva imagen en el historial
            HistorialImagene::create([
                'usuario_id' => $usuario->id_usuario ?? $usuario->id,
                'nombre_imagen' => $filename,
                'fecha_subida' => now(),
            ]);
        }

        return redirect()->route('profile')->with('success', 'Imagen de perfil actualizada.');
    }

    public function deleteImage()
    {
        $usuario = Auth::user();

        if ($usuario->imagen && $usuario->imagen !== 'UsuarioSinPerfil.png') {
            // Registrar en historial_imagenes antes de desvincular si no está ya registrada
            $yaRegistrada = HistorialImagene::where('usuario_id', $usuario->id_usuario ?? $usuario->id)
                ->where('nombre_imagen', $usuario->imagen)->exists();
            if (!$yaRegistrada) {
                HistorialImagene::create([
                    'usuario_id' => $usuario->id_usuario ?? $usuario->id,
                    'nombre_imagen' => $usuario->imagen,
                    'fecha_subida' => now(),
                ]);
            }
            // Dejar el campo imagen en null para que el accessor muestre la imagen por defecto (URL)
            $usuario->imagen = null;
            $usuario->save();
            return redirect()->route('profile')->with('success', 'Imagen de perfil eliminada.');
        }
        return redirect()->route('profile')->with('success', 'No tenías imagen de perfil para eliminar.');

    }

    // Eliminar imagen del historial (y archivo físico si no está en uso)
    public function deleteImageFromHistorial(Request $request)
    {
        $usuario = Auth::user();
        $imagen = $request->input('imagen');
        $historial = $usuario->historialImagenes()->where('nombre_imagen', $imagen)->first();
        if ($historial) {
            // Solo borrar archivo físico si no está en uso como foto de perfil
            if ($usuario->imagen !== $imagen) {
                $ruta = public_path('uploads/' . $imagen);
                if (file_exists($ruta)) {
                    @unlink($ruta);
                }
            }
            $historial->delete();
            return redirect()->route('profile')->with('success', 'Imagen eliminada del historial.');
        } else {
            return redirect()->route('profile')->with('error', 'No se encontró la imagen en tu historial.');
        }
    }
}