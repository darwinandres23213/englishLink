<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable {
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    
    // Cargar automáticamente las relaciones
    protected $with = ['rol', 'estado'];
    
    protected $fillable = [
        'nombre',
        'apellido', 
        'email',
        'contrasena',
        'rol_id',
        'estado_id',
        'imagen',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'contrasena' => 'hashed',
    ];

    
    // Laravel Auth necesita estos métodos
    public function getAuthPassword() {
        return $this->contrasena;
    }

    public function getEmailForPasswordReset() {
        return $this->email;
    }


    // Relaciones
    public function rol() {
        return $this->belongsTo(Role::class, 'rol_id', 'id_rol');
    }
    public function estado() {
        return $this->belongsTo(Estado::class, 'estado_id', 'id_estado');
    }


    public function historialImagenes() {
        return $this->hasMany(HistorialImagene::class, 'usuario_id', 'id_usuario');
    }


    // Métodos de utilidad
    public function isAdmin() {
        return $this->rol->nombre_rol === 'Administrador';
    }
    public function isProfesor() {
        return $this->rol->nombre_rol === 'Profesor';
    }
    public function isEstudiante() {
        return $this->rol->nombre_rol === 'Estudiante';
    }
    public function hasRole($roleName) {
        return $this->rol->nombre_rol === $roleName;
    }
    public function isActivo() {
        return $this->estado->nombre_estado === 'Activo';
    }
    public function getDashboardRoute() {

        switch ($this->rol->nombre_rol) {
            case 'Administrador':
                return route('admin.dashboard');
            case 'Profesor':
                return route('profesor.dashboard');
            case 'Estudiante':
                return route('estudiante.dashboard');
            case 'Coordinador':
                return route('coordinador.dashboard');
            case 'Secretario':
                return route('secretario.dashboard');
            default:
                return route('dashboard.general');
        }
    }


    // Relaciones para el sistema de actividades
    public function actividadesCreadas() {
        return $this->hasMany(Actividad::class, 'profesor_id', 'id_usuario');
    }
    public function entregasActividades() {
        return $this->hasMany(EntregaActividad::class, 'estudiante_id', 'id_usuario');
    }
    public function matriculas() {
        return $this->hasMany(Matricula::class, 'estudiante_id', 'id_usuario');
    }
    public function cursosComoProfesor() {
        return $this->hasMany(Curso::class, 'profesor_id', 'id_usuario');
    }


    // Obtener cursos donde está inscrito como estudiante
    public function cursosComoEstudiante() {
        return $this->belongsToMany(Curso::class, 'matriculas', 'estudiante_id', 'curso_id', 'id_usuario', 'id_curso');
    }


    // Verificar si es profesor de un curso específico
    public function esProfesorDeCurso($curso_id) {
        return $this->cursosComoProfesor()->where('id_curso', $curso_id)->exists();
    }


    // Verificar si está matriculado en un curso específico
    public function estaMatriculadoEnCurso($curso_id) {
        return $this->matriculas()->where('curso_id', $curso_id)->exists();
    }


    // Nombre completo 'componente'
    public function getNombreCompletoAttribute() {
        return trim(($this->nombre ?? $this->name ?? 'Usuario') . ' ' . ($this->apellido ?? ''));
    }
    // Accessor para la URL de la imagen de perfil
    public function getUrlImagenPerfilAttribute() {
        $img = $this->imagen ?? $this->profile_image ?? null;
        return $img ? asset('uploads/' . $img) : 'https://cdn-icons-png.flaticon.com/512/10302/10302971.png';
    }

}