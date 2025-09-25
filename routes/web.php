<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\MediosPagoController;
use App\Http\Controllers\AsignacionActividadeController;
use App\Http\Controllers\HistorialImageneController;
use App\Http\Controllers\RegistroActividadeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TiposEstadoController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\NiveleController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\EvaluacioneController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\RegistroCalificacioneController;
use App\Http\Controllers\RecuperacioneController;
use App\Http\Controllers\HistorialRecuperacioneController;
use App\Http\Controllers\NotificacioneController;
use App\Http\Controllers\AlertaController;

// Sistema de Actividades
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\EntregaActividadController;




// ===============================================
// 🥭RUTAS DE AUTENTICACIÓN
// ===============================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);




// ===============================================
// 🥭DASHBOARDS PROTEGIDOS (NUEVOS)
// ===============================================
Route::middleware(['auth', 'prevent.back'])->group(function () {
    Route::post('/profile/image/remove', [ProfileController::class, 'removeProfileImage'])->name('profile.image.remove');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/profesor/dashboard', [DashboardController::class, 'profesorDashboard'])->name('profesor.dashboard');
    Route::get('/estudiante/dashboard', [DashboardController::class, 'estudianteDashboard'])->name('estudiante.dashboard');
    Route::get('/coordinador/dashboard', [DashboardController::class, 'coordinadorDashboard'])->name('coordinador.dashboard');
    Route::get('/secretario/dashboard', [DashboardController::class, 'secretarioDashboard'])->name('secretario.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'generalDashboard'])->name('dashboard.general');
});




/* ===============================================
🥭TUS RUTAS EXISTENTES (PROTEGIDAS POR ROLES)

    🟢 ADMINISTRADORES
    ⚪ PROFESORES
    🔴 ESTUDIANTES
    🟡 COORDINADORES
    🔵 SECRETARIOS
=============================================*/

// RUTAS ACCESIBLES PARA TODOS LOS USUARIOS AUTENTICADOS
Route::middleware(['auth', 'prevent.back'])->group(function () {
    // Rutas y funciones de Perfil de Usuario (Todos los usuarios)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.image');
    Route::post('/profile/image/use', [ProfileController::class, 'useImageFromHistorial'])->name('profile.image.use');
    Route::post('/profile/image/delete', [ProfileController::class, 'deleteImageFromHistorial'])->name('profile.image.delete');

    // Mensajes (Todos los usuarios pueden ver mensajes)
    Route::get('/mensajes', [MensajeController::class, 'index'])->name('mensajes.index');
    Route::get('/mensajes/create', [MensajeController::class, 'create'])->name('mensajes.create');
    Route::post('/mensajes', [MensajeController::class, 'store'])->name('mensajes.store');
    Route::get('/mensajes/{mensaje}/edit', [MensajeController::class, 'edit'])->name('mensajes.edit');
    Route::put('/mensajes/{mensaje}', [MensajeController::class, 'update'])->name('mensajes.update');
    Route::delete('/mensajes/{mensaje}', [MensajeController::class, 'destroy'])->name('mensajes.destroy');
});




// RUTAS SOLO PARA 🟢ADMINISTRADORES
Route::middleware(['auth', 'prevent.back', 'role:admin'])->group(function () {
    // Gestión de Usuarios (Solo Admin)
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');
    Route::get('/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // Gestión de Roles (Solo Admin)
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{rol}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{rol}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{rol}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/roles/export/pdf', [RoleController::class, 'exportPdf'])->name('roles.export.pdf');

    // Estados y Tipos de Estados (Solo Admin)
    Route::get('/tipos_estados', [TiposEstadoController::class, 'index'])->name('tipos_estados.index');
    Route::get('/tipos_estados/create', [TiposEstadoController::class, 'create'])->name('tipos_estados.create');
    Route::post('/tipos_estados', [TiposEstadoController::class, 'store'])->name('tipos_estados.store');
    Route::get('/tipos_estados/{tipo}/edit', [TiposEstadoController::class, 'edit'])->name('tipos_estados.edit');
    Route::put('/tipos_estados/{tipo}', [TiposEstadoController::class, 'update'])->name('tipos_estados.update');
    Route::delete('/tipos_estados/{tipo}', [TiposEstadoController::class, 'destroy'])->name('tipos_estados.destroy');

    Route::get('/estados', [EstadoController::class, 'index'])->name('estados.index');
    Route::get('/estados/create', [EstadoController::class, 'create'])->name('estados.create');
    Route::post('/estados', [EstadoController::class, 'store'])->name('estados.store');
    Route::get('/estados/{estado}/edit', [EstadoController::class, 'edit'])->name('estados.edit');
    Route::put('/estados/{estado}', [EstadoController::class, 'update'])->name('estados.update');
    Route::delete('/estados/{estado}', [EstadoController::class, 'destroy'])->name('estados.destroy');

    // Medios de Pago (Admin tiene control total)
    Route::get('/mediopago', [MediosPagoController::class, 'index'])->name('mediopago.index');
    Route::get('/mediopago/create', [MediosPagoController::class, 'create'])->name('mediopago.create');
    Route::post('/mediopago', [MediosPagoController::class, 'store'])->name('mediopago.store');
    Route::get('/mediopago/{medio}/edit', [MediosPagoController::class, 'edit'])->name('mediopago.edit');
    Route::put('/mediopago/{medio}', [MediosPagoController::class, 'update'])->name('mediopago.update');
    Route::delete('/mediopago/{medio}', [MediosPagoController::class, 'destroy'])->name('mediopago.destroy');
    Route::get('/mediopago/export/pdf', [MediosPagoController::class, 'exportPdf'])->name('mediopago.export.pdf');
    Route::get('/mediopago/export/excel', [MediosPagoController::class, 'exportExcel'])->name('mediopago.export.excel');

    // Registro de Actividades (Solo Admin)
    Route::get('/registro_actividades', [RegistroActividadeController::class, 'index'])->name('registro_actividades.index');
    Route::get('/registro_actividades/create', [RegistroActividadeController::class, 'create'])->name('registro_actividades.create');
    Route::post('/registro_actividades', [RegistroActividadeController::class, 'store'])->name('registro_actividades.store');
    Route::get('/registro_actividades/{actividad}/edit', [RegistroActividadeController::class, 'edit'])->name('registro_actividades.edit');
    Route::put('/registro_actividades/{actividad}', [RegistroActividadeController::class, 'update'])->name('registro_actividades.update');
    Route::delete('/registro_actividades/{actividad}', [RegistroActividadeController::class, 'destroy'])->name('registro_actividades.destroy');
    Route::get('/registro_actividades/export/pdf', [RegistroActividadeController::class, 'exportPdf'])->name('registro_actividades.export.pdf');
});




// RUTAS PARA 🟢ADMINISTRADORES Y 🟡COORDINADORES
Route::middleware(['auth', 'prevent.back', 'role:admin,coordinador'])->group(function () {
    // Gestión de Cursos
    Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
    Route::get('/cursos/create', [CursoController::class, 'create'])->name('cursos.create');
    Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');
    Route::get('/cursos/{curso}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
    Route::put('/cursos/{curso}', [CursoController::class, 'update'])->name('cursos.update');
    Route::delete('/cursos/{curso}', [CursoController::class, 'destroy'])->name('cursos.destroy');

    // Gestión de Niveles
    Route::get('/niveles', [NiveleController::class, 'index'])->name('niveles.index');
    Route::get('/niveles/create', [NiveleController::class, 'create'])->name('niveles.create');
    Route::post('/niveles', [NiveleController::class, 'store'])->name('niveles.store');
    Route::get('/niveles/{nivel}/edit', [NiveleController::class, 'edit'])->name('niveles.edit');
    Route::put('/niveles/{nivel}', [NiveleController::class, 'update'])->name('niveles.update');
    Route::delete('/niveles/{nivel}', [NiveleController::class, 'destroy'])->name('niveles.destroy');

    // Asignación de Actividades
    Route::get('/asignacion-actividades', [AsignacionActividadeController::class, 'index'])->name('asignacion-actividades.index');
    Route::get('/asignacion-actividades/create', [AsignacionActividadeController::class, 'create'])->name('asignacion-actividades.create');
    Route::post('/asignacion-actividades', [AsignacionActividadeController::class, 'store'])->name('asignacion-actividades.store');
    Route::get('/asignacion-actividades/{asignacion_actividade}/edit', [AsignacionActividadeController::class, 'edit'])->name('asignacion-actividades.edit');
    Route::put('/asignacion-actividades/{asignacion_actividade}', [AsignacionActividadeController::class, 'update'])->name('asignacion-actividades.update');
    Route::delete('/asignacion-actividades/{asignacion_actividade}', [AsignacionActividadeController::class, 'destroy'])->name('asignacion-actividades.destroy');
});




// RUTAS PARA 🟢ADMINISTRADORES, 🟡COORDINADORES Y 🔵SECRETARIOS
Route::middleware(['auth', 'prevent.back', 'role:admin,coordinador,secretario'])->group(function () {
    // Gestión de Matrículas
    Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index');
    Route::get('/matriculas/create', [MatriculaController::class, 'create'])->name('matriculas.create');
    Route::post('/matriculas', [MatriculaController::class, 'store'])->name('matriculas.store');
    Route::get('/matriculas/{matricula}/edit', [MatriculaController::class, 'edit'])->name('matriculas.edit');
    Route::put('/matriculas/{matricula}', [MatriculaController::class, 'update'])->name('matriculas.update');
    Route::delete('/matriculas/{matricula}', [MatriculaController::class, 'destroy'])->name('matriculas.destroy');

    // Gestión de Pagos
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
    Route::get('/pagos/create', [PagoController::class, 'create'])->name('pagos.create');
    Route::post('/pagos', [PagoController::class, 'store'])->name('pagos.store');
    Route::get('/pagos/{pago}/ver', [PagoController::class, 'showComprobante'])->name('pago.comprobante');
    Route::get('/pagos/{pago}/edit', [PagoController::class, 'edit'])->name('pagos.edit');
    Route::put('/pagos/{pago}', [PagoController::class, 'update'])->name('pagos.update');
    Route::delete('/pagos/{pago}', [PagoController::class, 'destroy'])->name('pagos.destroy');
    Route::get('/pagos/export/pdf', [PagoController::class, 'exportPdf'])->name('pagos.export.pdf');
    Route::get('/pagos/export/excel', [PagoController::class, 'exportExcel'])->name('pagos.export.excel');
    Route::get('/pagos/{pago}/comprobante', [PagoController::class, 'comprobantePdf'])->name('pagos.comprobante.pdf');
});




// RUTAS PARA ⚪PROFESORES, 🟡COORDINADORES Y 🟢ADMINISTRADORES
Route::middleware(['auth', 'prevent.back', 'role:admin,coordinador,profesor'])->group(function () {
    // Ruta específica para profesores - Mis Clases
    Route::get('/profesor/mis-clases', [ClaseController::class, 'misClases'])->name('profesor.mis-clases');
    Route::get('/profesor/curso/{curso}', [ClaseController::class, 'verCurso'])->name('profesor.curso.detalle');
    
    // Gestión de Clases
    Route::get('/clases', [ClaseController::class, 'index'])->name('clases.index');
    Route::get('/clases/create', [ClaseController::class, 'create'])->name('clases.create');
    Route::post('/clases', [ClaseController::class, 'store'])->name('clases.store');
    Route::get('/clases/{clase}/edit', [ClaseController::class, 'edit'])->name('clases.edit');
    Route::put('/clases/{clase}', [ClaseController::class, 'update'])->name('clases.update');
    Route::delete('/clases/{clase}', [ClaseController::class, 'destroy'])->name('clases.destroy');

    // Gestión de Horarios
    Route::get('/horarios', [HorarioController::class, 'index'])->name('horarios.index');
    Route::get('/horarios/create', [HorarioController::class, 'create'])->name('horarios.create');
    Route::post('/horarios', [HorarioController::class, 'store'])->name('horarios.store');
    Route::get('/horarios/{horario}/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
    Route::put('/horarios/{horario}', [HorarioController::class, 'update'])->name('horarios.update');
    Route::delete('/horarios/{horario}', [HorarioController::class, 'destroy'])->name('horarios.destroy');

    // Gestión de Evaluaciones
    Route::get('/evaluaciones', [EvaluacioneController::class, 'index'])->name('evaluaciones.index');
    Route::get('/evaluaciones/create', [EvaluacioneController::class, 'create'])->name('evaluaciones.create');
    Route::post('/evaluaciones', [EvaluacioneController::class, 'store'])->name('evaluaciones.store');
    Route::get('/evaluaciones/{evaluacione}/edit', [EvaluacioneController::class, 'edit'])->name('evaluaciones.edit');
    Route::put('/evaluaciones/{evaluacione}', [EvaluacioneController::class, 'update'])->name('evaluaciones.update');
    Route::delete('/evaluaciones/{evaluacione}', [EvaluacioneController::class, 'destroy'])->name('evaluaciones.destroy');

    // Gestión de Asistencias
    Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
    Route::get('/asistencias/create', [AsistenciaController::class, 'create'])->name('asistencias.create');
    Route::get('/asistencias/estudiantes-por-clase', [AsistenciaController::class, 'getEstudiantesPorClase'])->name('asistencias.estudiantes-por-clase');
    Route::get('/asistencias/registrar-masivo', [AsistenciaController::class, 'registrarMasivo'])->name('asistencias.registrar.masivo');
    Route::post('/asistencias/store-masivo', [AsistenciaController::class, 'storeMasivo'])->name('asistencias.store.masivo');
    Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
    Route::get('/asistencias/{asistencia}/edit', [AsistenciaController::class, 'edit'])->name('asistencias.edit');
    Route::put('/asistencias/{asistencia}', [AsistenciaController::class, 'update'])->name('asistencias.update');
    Route::delete('/asistencias/{asistencia}', [AsistenciaController::class, 'destroy'])->name('asistencias.destroy');

    // Gestión de Calificaciones
    Route::get('/notas', [NotaController::class, 'index'])->name('notas.index');
    Route::get('/notas/create', [NotaController::class, 'create'])->name('notas.create');
    Route::post('/notas', [NotaController::class, 'store'])->name('notas.store');
    Route::get('/notas/{nota}/edit', [NotaController::class, 'edit'])->name('notas.edit');
    Route::put('/notas/{nota}', [NotaController::class, 'update'])->name('notas.update');
    Route::delete('/notas/{nota}', [NotaController::class, 'destroy'])->name('notas.destroy');

    // Recuperaciones
    Route::get('/recuperaciones', [RecuperacioneController::class, 'index'])->name('recuperaciones.index');
    Route::get('/recuperaciones/create', [RecuperacioneController::class, 'create'])->name('recuperaciones.create');
    Route::post('/recuperaciones', [RecuperacioneController::class, 'store'])->name('recuperaciones.store');
    Route::get('/recuperaciones/{recuperacione}/edit', [RecuperacioneController::class, 'edit'])->name('recuperaciones.edit');
    Route::put('/recuperaciones/{recuperacione}', [RecuperacioneController::class, 'update'])->name('recuperaciones.update');
    Route::delete('/recuperaciones/{recuperacione}', [RecuperacioneController::class, 'destroy'])->name('recuperaciones.destroy');

    // Registro de Calificaciones
    Route::get('/registro_calificaciones', [RegistroCalificacioneController::class, 'index'])->name('registro_calificaciones.index');
    Route::get('/registro_calificaciones/create', [RegistroCalificacioneController::class, 'create'])->name('registro_calificaciones.create');
    Route::post('/registro_calificaciones', [RegistroCalificacioneController::class, 'store'])->name('registro_calificaciones.store');
    Route::get('/registro_calificaciones/{registro_calificacione}/edit', [RegistroCalificacioneController::class, 'edit'])->name('registro_calificaciones.edit');
    Route::put('/registro_calificaciones/{registro_calificacione}', [RegistroCalificacioneController::class, 'update'])->name('registro_calificaciones.update');
    Route::delete('/registro_calificaciones/{registro_calificacione}', [RegistroCalificacioneController::class, 'destroy'])->name('registro_calificaciones.destroy');
});




// RUTAS PARA 🔴ESTUDIANTES (solo lectura en la mayoría de casos)
Route::middleware(['auth', 'prevent.back', 'role:admin,coordinador,secretario,profesor,estudiante'])->group(function () {
    // Consulta de Horarios (Todos pueden ver)
    Route::get('/horarios', [HorarioController::class, 'index'])->name('horarios.index');
    
    // Los estudiantes pueden ver sus propias notas y matrículas
    Route::get('/notas', [NotaController::class, 'index'])->name('notas.index');
    Route::get('/matriculas', [MatriculaController::class, 'index'])->name('matriculas.index');
});




// RUTAS PARA SISTEMA DE ACTIVIDADES
Route::middleware(['auth', 'prevent.back'])->group(function () {
    
    // RUTAS PARA ⚪PROFESORES Y 🟢ADMINISTRADORES - Gestión de Actividades
    Route::middleware(['role:admin,profesor'])->group(function () {
        Route::get('/actividades', [ActividadController::class, 'index'])->name('actividades.index');
        Route::get('/actividades/create', [ActividadController::class, 'create'])->name('actividades.create');
        Route::post('/actividades', [ActividadController::class, 'store'])->name('actividades.store');
        Route::get('/actividades/{actividad}', [ActividadController::class, 'show'])->name('actividades.show');
        Route::get('/actividades/{actividad}/edit', [ActividadController::class, 'edit'])->name('actividades.edit');
        Route::put('/actividades/{actividad}', [ActividadController::class, 'update'])->name('actividades.update');
        Route::delete('/actividades/{actividad}', [ActividadController::class, 'destroy'])->name('actividades.destroy');
        Route::get('/actividades/{actividad}/calificar', [ActividadController::class, 'calificar'])->name('actividades.calificar');
        
        // Calificar entregas específicas
        Route::post('/entregas/{entrega}/calificar', [EntregaActividadController::class, 'calificar'])->name('entregas.calificar');
        
        // Ver entregas de estudiantes para una actividad específica
        Route::get('/actividades/{actividad}/entregas', [EntregaActividadController::class, 'verEntregas'])->name('actividades.entregas');
    });

    // RUTAS PARA 🔴ESTUDIANTES - Ver y entregar actividades
    Route::middleware(['role:admin,estudiante'])->group(function () {
        Route::get('/mis-actividades', [EntregaActividadController::class, 'misActividades'])->name('estudiante.actividades');
        Route::get('/mis-asistencias', [AsistenciaController::class, 'misAsistencias'])->name('estudiante.asistencias');
        Route::get('/actividad/{entrega}', [EntregaActividadController::class, 'show'])->name('estudiante.actividad.show');
        Route::put('/actividad/{entrega}/entregar', [EntregaActividadController::class, 'update'])->name('estudiante.actividad.entregar');
    });

    // RUTAS PARA TODOS LOS ROLES AUTORIZADOS - Descargar archivos
    Route::middleware(['role:admin,profesor,estudiante'])->group(function () {
        Route::get('/entrega/{entrega}/archivo', [EntregaActividadController::class, 'descargarArchivo'])->name('entrega.descargar');
    });
});




// 🟢ADMINISTRADORES 🟡COORDINADORES : RUTAS ADICIONALES (Historial, Notificaciones y Alertas)
Route::middleware(['auth', 'prevent.back', 'role:admin,coordinador'])->group(function () {
    // Historial de Imágenes
    Route::get('/historial_imagenes', [HistorialImageneController::class, 'index'])->name('historial_imagenes.index');
    Route::get('/historial_imagenes/create', [HistorialImageneController::class, 'create'])->name('historial_imagenes.create');
    Route::post('/historial_imagenes', [HistorialImageneController::class, 'store'])->name('historial_imagenes.store');
    Route::get('/historial_imagenes/{historial_imagene}/edit', [HistorialImageneController::class, 'edit'])->name('historial_imagenes.edit');
    Route::put('/historial_imagenes/{historial_imagene}', [HistorialImageneController::class, 'update'])->name('historial_imagenes.update');
    Route::delete('/historial_imagenes/{historial_imagene}', [HistorialImageneController::class, 'destroy'])->name('historial_imagenes.destroy');

    // Historial de Recuperaciones
    Route::get('/historial_recuperaciones', [HistorialRecuperacioneController::class, 'index'])->name('historial_recuperaciones.index');
    Route::get('/historial_recuperaciones/create', [HistorialRecuperacioneController::class, 'create'])->name('historial_recuperaciones.create');
    Route::post('/historial_recuperaciones', [HistorialRecuperacioneController::class, 'store'])->name('historial_recuperaciones.store');
    Route::get('/historial_recuperaciones/{historial_recuperacione}/edit', [HistorialRecuperacioneController::class, 'edit'])->name('historial_recuperaciones.edit');
    Route::put('/historial_recuperaciones/{historial_recuperacione}', [HistorialRecuperacioneController::class, 'update'])->name('historial_recuperaciones.update');
    Route::delete('/historial_recuperaciones/{historial_recuperacione}', [HistorialRecuperacioneController::class, 'destroy'])->name('historial_recuperaciones.destroy');

    // Notificaciones y Alertas
    Route::get('/notificaciones', [NotificacioneController::class, 'index'])->name('notificaciones.index');
    Route::get('/notificaciones/create', [NotificacioneController::class, 'create'])->name('notificaciones.create');
    Route::post('/notificaciones', [NotificacioneController::class, 'store'])->name('notificaciones.store');
    Route::get('/notificaciones/{notificacione}/edit', [NotificacioneController::class, 'edit'])->name('notificaciones.edit');
    Route::put('/notificaciones/{notificacione}', [NotificacioneController::class, 'update'])->name('notificaciones.update');
    Route::delete('/notificaciones/{notificacione}', [NotificacioneController::class, 'destroy'])->name('notificaciones.destroy');

    Route::get('/alertas', [AlertaController::class, 'index'])->name('alertas.index');
    Route::get('/alertas/create', [AlertaController::class, 'create'])->name('alertas.create');
    Route::post('/alertas', [AlertaController::class, 'store'])->name('alertas.store');
    Route::get('/alertas/{alerta}/edit', [AlertaController::class, 'edit'])->name('alertas.edit');
    Route::put('/alertas/{alerta}', [AlertaController::class, 'update'])->name('alertas.update');
    Route::delete('/alertas/{alerta}', [AlertaController::class, 'destroy'])->name('alertas.destroy');
});




//======================================================
// 🥭RUTAS PÚBLICAS
// ===============================================
Route::get('/', function () {
    return view('public.welcome');
})->name('welcome');

Route::get('/about', function () {
    return view('public.about');
})->name('public.about');

Route::get('/courses', function () {
    return view('public.courses');
})->name('public.courses');

Route::get('/contact', function () {
    return view('public.contact');
})->name('public.contact');