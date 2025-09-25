{{-- filepath: resources/views/layouts/sidebar.blade.php --}}
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ Auth::user()->getDashboardRoute() }}">

      <div class="sidebar-brand-icon rotate-n-15"> <!-- Logo creado en canva -->
         <img src="{{ asset('img/44.png') }}" alt="Logo" style="width: 150px; height: 100px; object-fit: contain;">
      </div>
      {{-- <div class="sidebar-brand-text mx-2">English Link!</div> --}}

      {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
      </div>
         <div class="sidebar-brand-text mx-2">
            English Link <sup>4</sup>
      </div> --}}
    </a>


    {{-- <hr class="sidebar-divider my-0"> --}}


    <!-- Dashboard -->
    <li class="nav-item mt-2 mb-2">
        <a class="nav-link {{ request()->routeIs('admin.dashboard', 'profesor.dashboard', 'estudiante.dashboard', 'coordinador.dashboard', 'secretario.dashboard') ? 'active' : '' }}" 
            href="{{ Auth::user()->getDashboardRoute() }}">
            <i class="fas fa-regular fa-house"></i>
            <span>Página principal</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Interface (Módulos) -->
    <div class="sidebar-heading">Módulos</div>



    
    <!-- Usuarios (solo admin) -->
    @if(Auth::user() && Auth::user()->isAdmin())
    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('usuarios.create', 'usuarios.index', 'roles.index') ? '' : 'collapsed' }}" 
            href="#" data-toggle="collapse" data-target="#collapseUsuarios"
            aria-expanded="{{ request()->routeIs('usuarios.create', 'usuarios.index', 'roles.index') ? 'true' : 'false' }}">
            <i class="fas fa-users"></i>
            <span>✅Usuarios</span>
        </a>
        <div id="collapseUsuarios" class="collapse {{ request()->routeIs('usuarios.create', 'usuarios.index', 'roles.index') ? 'show' : '' }}"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item {{ request()->routeIs('usuarios.index') ? 'active' : '' }}" 
                    href="{{ route('usuarios.index') }}">✅Usuarios
                </a>

                <a class="collapse-item {{ request()->routeIs('usuarios.create') ? 'active' : '' }}" 
                    href="{{ route('usuarios.create') }}">✅Crear Usuario
                </a>

                <!-- <a class="collapse-item" href="#{{-- route('login') --}}">Iniciar Sesión - (Camilo)</a> -->
                <!-- <a class="collapse-item" href="#{{-- route('roles.asignar') --}}">Asignar Roles - (Richard)</a> -->
                <!-- <a class="collapse-item" href="#{{-- route('usuarios.gestion') --}}">Gestionar Usuarios - (David)</a> -->

                <a class="collapse-item {{ request()->routeIs('roles.index') ? 'active' : '' }}"
                   href="{{ route('roles.index') }}">✅Lista de Roles
                </a>
            </div>
        </div>
    </li>
    @endif




    <!-- Cursos -->
    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('cursos.index', 'matriculas.index') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseCursos"
           aria-expanded="{{ request()->routeIs('cursos.index', 'matriculas.index') ? 'true' : 'false' }}">
            <i class="fas fa-book"></i>
            <span>Cursos</span>
        </a>
        <div id="collapseCursos" class="collapse {{ request()->routeIs('cursos.index', 'matriculas.index') ? 'show' : '' }}" 
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('cursos.index') ? 'active' : '' }}" 
                   href="{{ route('cursos.index') }}">✅Cursos
                </a>

                <a class="collapse-item {{ request()->routeIs('matriculas.index') ? 'active' : '' }}" 
                   href="{{ route('matriculas.index') }}">✅Matriculas
                </a>

                <a class="collapse-item {{ request()->routeIs('pagos.*') ? 'active' : '' }}" 
                   href="#">Panel de Control Personalizado
                </a>

                <a class="collapse-item {{ request()->routeIs('mediopago.*') ? 'active' : '' }}" 
                   href="#">Notificaciones y Mensajería
                </a>

                <a class="collapse-item {{ request()->routeIs('mediopago.*') ? 'active' : '' }}" 
                   href="#">⛔Seguridad y Privacidad
                </a>

                <a class="collapse-item {{ request()->routeIs('mediopago.*') ? 'active' : '' }}" 
                   href="#">Registro de Actividades
                </a>

                <a class="collapse-item {{ request()->routeIs('mediopago.*') ? 'active' : '' }}" 
                   href="#">Interacción con el Catálogo de Cursos
                </a>

                <a class="collapse-item {{ request()->routeIs('mediopago.*') ? 'active' : '' }}" 
                   href="#">Calendario de Clases
                </a>

            </div>
        </div>
    </li>




    <!-- Calificaciones -->
    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('#') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseCalificaciones"
           aria-expanded="{{ request()->routeIs('#') ? 'true' : 'false' }}">
            <i class="fas fa-graduation-cap"></i>
            <span>Calificaciones</span>
        </a>
        <div id="collapseCalificaciones" class="collapse {{ request()->routeIs('#') ? 'show' : '' }}" 
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Registro de Calificaciones
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Gestión de Calificaciones
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Visualización de Calificaciones
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Recuperación del Curso
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Historial de Calificaciones
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">⛔Envía notificaciones automáticas a los usuarios cuando se asignan nuevas calificaciones.
                </a>
            </div>
        </div>
    </li>




    <!-- Horarios -->
    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('horarios.index') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseHorarios"
           aria-expanded="{{ request()->routeIs('horarios.index') ? 'true' : 'false' }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Horarios</span>
        </a>
        <div id="collapseHorarios" class="collapse {{ request()->routeIs('horarios.index') ? 'show' : '' }}" 
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('horarios.index') ? 'active' : '' }}" 
                   href="{{ route('horarios.index') }}">✅Horarios
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Creación y Gestión de Horarios Personalizados
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">⛔Asignación de Actividades de Aprendizaje a Bloques de Tiempo
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Gestionar Horarios
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">⛔Configuración de Recordatorios y Alertas
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Ejemplo_Tittle_Pag
                </a>

            </div>
        </div>
    </li>




    <!-- Pagos -->
    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('pagos.index', 'pagos.create', 'pagos.edit') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapsePagos"
           aria-expanded="{{ request()->routeIs('pagos.index') ? 'true' : 'false' }}">
            <i class="fas fa-money-bill-wave"></i>
            <span>Pagos</span>
        </a>
        <div id="collapsePagos" class="collapse {{ request()->routeIs('pagos.index') ? 'show' : '' }}" 
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('pagos.index') ? 'active' : '' }}" 
                   href="{{ route('pagos.index') }}">✅Pagos
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Pago
                </a>
                
                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Comprobante de Pago
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">⛔Envío Automático por Correo
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Histórico de Comprobantes
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Ejemplo_Tittle_Pag
                </a>
                
            </div>
        </div>
    </li>




    <!-- Vistas Adicionales -->
    <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('estados.index', 'tipos_estados.index', 'niveles.index', 'mediopago.index', 'historial_imagenes.index', 'asignacion-actividades.index') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapselinksVistasAdicionales"
           aria-expanded="{{ request()->routeIs('estados.index', 'tipos_estados.index', 'niveles.index', 'mediopago.index', 'historial_imagenes.index', 'asignacion-actividades.index') ? 'true' : 'false' }}">
            <i class="fas fa-eye"></i>
            <span>Vistas Adicionales</span>
        </a>
        <div id="collapselinksVistasAdicionales" class="collapse {{ request()->routeIs('estados.index', 'tipos_estados.index', 'niveles.index', 'mediopago.index', 'historial_imagenes.index', 'asignacion-actividades.index') ? 'show' : '' }}" 
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('estados.index') ? 'active' : '' }}" 
                   href="{{ route('estados.index') }}">✅Estados
                </a>

                <a class="collapse-item {{ request()->routeIs('tipos_estados.index') ? 'active' : '' }}" 
                   href="{{ route('tipos_estados.index') }}">✅Tipos de Estados
                </a>

                <a class="collapse-item {{ request()->routeIs('niveles.index') ? 'active' : '' }}" 
                   href="{{ route('niveles.index') }}">✅Niveles
                </a>

                <a class="collapse-item {{ request()->routeIs('mediopago.index') ? 'active' : '' }}" 
                   href="{{ route('mediopago.index') }}">✅Medios de Pago
                </a>

                <a class="collapse-item {{ request()->routeIs('asignacion-actividades.index') ? 'active' : '' }}" 
                   href="{{ route('asignacion-actividades.index') }}">⚠️Asignacion Actividades
                </a>

                <a class="collapse-item {{ request()->routeIs('historial_imagenes.index') ? 'active' : '' }}" 
                   href="{{ route('historial_imagenes.index') }}">⚠️Historial Imagenes
                </a>

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Ejemplo_Tittle_Pag
                </a>

            </div>
        </div>
    </li>




    <!-- 😉 Plantilla de ejemplo para nuevas secciones -->
    {{-- <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('#') ? '' : 'collapsed' }}" 
           href="#" data-toggle="collapse" data-target="#collapseCalificaciones"
           aria-expanded="{{ request()->routeIs('#') ? 'true' : 'false' }}">
            <i class="fas fa-graduation-cap"></i>
            <span>Calificaciones</span>
        </a>
        <div id="collapseCalificaciones" class="collapse {{ request()->routeIs('#') ? 'show' : '' }}" 
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item {{ request()->routeIs('#') ? 'active' : '' }}" 
                   href="#">Ejemplo_Tittle_Pag
                </a>

            </div>
        </div>
    </li> --}}




    <hr class="sidebar-divider mt-3">
   {{-- <div class="sidebar-heading">
      Complementos
   </div> --}}




    {{-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span>
        </a>
    </li> --}}

   <li class="nav-item mt-2 mb-2">
      <x-Boton-LogOut variant="para_sidebar" />
   </li>


    {{-- <hr class="sidebar-divider d-none d-md-block"> --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-corner border-0" id="sidebarToggle"></button>
    </div>
</ul>