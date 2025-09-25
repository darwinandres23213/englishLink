
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo e(Auth::user()->getDashboardRoute()); ?>">

      <div class="sidebar-brand-icon rotate-n-15"> <!-- Logo creado en canva -->
         <img src="<?php echo e(asset('img/44.png')); ?>" alt="Logo" style="width: 150px; height: 100px; object-fit: contain;">
      </div>
      

      
    </a>


    


    <!-- Dashboard -->
    <li class="nav-item mt-2 mb-2">
        <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard', 'profesor.dashboard', 'estudiante.dashboard', 'coordinador.dashboard', 'secretario.dashboard') ? 'active' : ''); ?>" 
            href="<?php echo e(Auth::user()->getDashboardRoute()); ?>">
            <i class="fas fa-regular fa-house"></i>
            <span>Página principal</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Interface (Módulos) -->
    <div class="sidebar-heading">Módulos</div>



    
    <!-- Usuarios (solo admin) -->
    <?php if(Auth::user() && Auth::user()->isAdmin()): ?>
    <li class="nav-item">
        <a class="nav-link collapsed <?php echo e(request()->routeIs('usuarios.create', 'usuarios.index', 'roles.index') ? '' : 'collapsed'); ?>" 
            href="#" data-toggle="collapse" data-target="#collapseUsuarios"
            aria-expanded="<?php echo e(request()->routeIs('usuarios.create', 'usuarios.index', 'roles.index') ? 'true' : 'false'); ?>">
            <i class="fas fa-users"></i>
            <span>✅Usuarios</span>
        </a>
        <div id="collapseUsuarios" class="collapse <?php echo e(request()->routeIs('usuarios.create', 'usuarios.index', 'roles.index') ? 'show' : ''); ?>"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item <?php echo e(request()->routeIs('usuarios.index') ? 'active' : ''); ?>" 
                    href="<?php echo e(route('usuarios.index')); ?>">✅Usuarios
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('usuarios.create') ? 'active' : ''); ?>" 
                    href="<?php echo e(route('usuarios.create')); ?>">✅Crear Usuario
                </a>

                <!-- <a class="collapse-item" href="#">Iniciar Sesión - (Camilo)</a> -->
                <!-- <a class="collapse-item" href="#">Asignar Roles - (Richard)</a> -->
                <!-- <a class="collapse-item" href="#">Gestionar Usuarios - (David)</a> -->

                <a class="collapse-item <?php echo e(request()->routeIs('roles.index') ? 'active' : ''); ?>"
                   href="<?php echo e(route('roles.index')); ?>">✅Lista de Roles
                </a>
            </div>
        </div>
    </li>
    <?php endif; ?>




    <!-- Cursos -->
    <li class="nav-item">
        <a class="nav-link collapsed <?php echo e(request()->routeIs('cursos.index', 'matriculas.index') ? '' : 'collapsed'); ?>" 
           href="#" data-toggle="collapse" data-target="#collapseCursos"
           aria-expanded="<?php echo e(request()->routeIs('cursos.index', 'matriculas.index') ? 'true' : 'false'); ?>">
            <i class="fas fa-book"></i>
            <span>Cursos</span>
        </a>
        <div id="collapseCursos" class="collapse <?php echo e(request()->routeIs('cursos.index', 'matriculas.index') ? 'show' : ''); ?>" 
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php echo e(request()->routeIs('cursos.index') ? 'active' : ''); ?>" 
                   href="<?php echo e(route('cursos.index')); ?>">✅Cursos
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('matriculas.index') ? 'active' : ''); ?>" 
                   href="<?php echo e(route('matriculas.index')); ?>">✅Matriculas
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('pagos.*') ? 'active' : ''); ?>" 
                   href="#">Panel de Control Personalizado
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('mediopago.*') ? 'active' : ''); ?>" 
                   href="#">Notificaciones y Mensajería
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('mediopago.*') ? 'active' : ''); ?>" 
                   href="#">⛔Seguridad y Privacidad
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('mediopago.*') ? 'active' : ''); ?>" 
                   href="#">Registro de Actividades
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('mediopago.*') ? 'active' : ''); ?>" 
                   href="#">Interacción con el Catálogo de Cursos
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('mediopago.*') ? 'active' : ''); ?>" 
                   href="#">Calendario de Clases
                </a>

            </div>
        </div>
    </li>




    <!-- Calificaciones -->
    <li class="nav-item">
        <a class="nav-link collapsed <?php echo e(request()->routeIs('#') ? '' : 'collapsed'); ?>" 
           href="#" data-toggle="collapse" data-target="#collapseCalificaciones"
           aria-expanded="<?php echo e(request()->routeIs('#') ? 'true' : 'false'); ?>">
            <i class="fas fa-graduation-cap"></i>
            <span>Calificaciones</span>
        </a>
        <div id="collapseCalificaciones" class="collapse <?php echo e(request()->routeIs('#') ? 'show' : ''); ?>" 
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Registro de Calificaciones
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Gestión de Calificaciones
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Visualización de Calificaciones
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Recuperación del Curso
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Historial de Calificaciones
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">⛔Envía notificaciones automáticas a los usuarios cuando se asignan nuevas calificaciones.
                </a>
            </div>
        </div>
    </li>




    <!-- Horarios -->
    <li class="nav-item">
        <a class="nav-link collapsed <?php echo e(request()->routeIs('horarios.index') ? '' : 'collapsed'); ?>" 
           href="#" data-toggle="collapse" data-target="#collapseHorarios"
           aria-expanded="<?php echo e(request()->routeIs('horarios.index') ? 'true' : 'false'); ?>">
            <i class="fas fa-calendar-alt"></i>
            <span>Horarios</span>
        </a>
        <div id="collapseHorarios" class="collapse <?php echo e(request()->routeIs('horarios.index') ? 'show' : ''); ?>" 
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php echo e(request()->routeIs('horarios.index') ? 'active' : ''); ?>" 
                   href="<?php echo e(route('horarios.index')); ?>">✅Horarios
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Creación y Gestión de Horarios Personalizados
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">⛔Asignación de Actividades de Aprendizaje a Bloques de Tiempo
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Gestionar Horarios
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">⛔Configuración de Recordatorios y Alertas
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Ejemplo_Tittle_Pag
                </a>

            </div>
        </div>
    </li>




    <!-- Pagos -->
    <li class="nav-item">
        <a class="nav-link collapsed <?php echo e(request()->routeIs('pagos.index', 'pagos.create', 'pagos.edit') ? '' : 'collapsed'); ?>" 
           href="#" data-toggle="collapse" data-target="#collapsePagos"
           aria-expanded="<?php echo e(request()->routeIs('pagos.index') ? 'true' : 'false'); ?>">
            <i class="fas fa-money-bill-wave"></i>
            <span>Pagos</span>
        </a>
        <div id="collapsePagos" class="collapse <?php echo e(request()->routeIs('pagos.index') ? 'show' : ''); ?>" 
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php echo e(request()->routeIs('pagos.index') ? 'active' : ''); ?>" 
                   href="<?php echo e(route('pagos.index')); ?>">✅Pagos
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Pago
                </a>
                
                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Comprobante de Pago
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">⛔Envío Automático por Correo
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Histórico de Comprobantes
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Ejemplo_Tittle_Pag
                </a>
                
            </div>
        </div>
    </li>




    <!-- Vistas Adicionales -->
    <li class="nav-item">
        <a class="nav-link collapsed <?php echo e(request()->routeIs('estados.index', 'tipos_estados.index', 'niveles.index', 'mediopago.index', 'historial_imagenes.index', 'asignacion-actividades.index') ? '' : 'collapsed'); ?>" 
           href="#" data-toggle="collapse" data-target="#collapselinksVistasAdicionales"
           aria-expanded="<?php echo e(request()->routeIs('estados.index', 'tipos_estados.index', 'niveles.index', 'mediopago.index', 'historial_imagenes.index', 'asignacion-actividades.index') ? 'true' : 'false'); ?>">
            <i class="fas fa-eye"></i>
            <span>Vistas Adicionales</span>
        </a>
        <div id="collapselinksVistasAdicionales" class="collapse <?php echo e(request()->routeIs('estados.index', 'tipos_estados.index', 'niveles.index', 'mediopago.index', 'historial_imagenes.index', 'asignacion-actividades.index') ? 'show' : ''); ?>" 
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?php echo e(request()->routeIs('estados.index') ? 'active' : ''); ?>" 
                   href="<?php echo e(route('estados.index')); ?>">✅Estados
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('tipos_estados.index') ? 'active' : ''); ?>" 
                   href="<?php echo e(route('tipos_estados.index')); ?>">✅Tipos de Estados
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('niveles.index') ? 'active' : ''); ?>" 
                   href="<?php echo e(route('niveles.index')); ?>">✅Niveles
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('mediopago.index') ? 'active' : ''); ?>" 
                   href="<?php echo e(route('mediopago.index')); ?>">✅Medios de Pago
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('asignacion-actividades.index') ? 'active' : ''); ?>" 
                   href="<?php echo e(route('asignacion-actividades.index')); ?>">⚠️Asignacion Actividades
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('historial_imagenes.index') ? 'active' : ''); ?>" 
                   href="<?php echo e(route('historial_imagenes.index')); ?>">⚠️Historial Imagenes
                </a>

                <a class="collapse-item <?php echo e(request()->routeIs('#') ? 'active' : ''); ?>" 
                   href="#">Ejemplo_Tittle_Pag
                </a>

            </div>
        </div>
    </li>




    <!-- 😉 Plantilla de ejemplo para nuevas secciones -->
    




    <hr class="sidebar-divider mt-3">
   




    

   <li class="nav-item mt-2 mb-2">
      <?php if (isset($component)) { $__componentOriginal88b1a350664f7799b0ced566355c46e6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88b1a350664f7799b0ced566355c46e6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.Boton-LogOut','data' => ['variant' => 'para_sidebar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('Boton-LogOut'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'para_sidebar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88b1a350664f7799b0ced566355c46e6)): ?>
<?php $attributes = $__attributesOriginal88b1a350664f7799b0ced566355c46e6; ?>
<?php unset($__attributesOriginal88b1a350664f7799b0ced566355c46e6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88b1a350664f7799b0ced566355c46e6)): ?>
<?php $component = $__componentOriginal88b1a350664f7799b0ced566355c46e6; ?>
<?php unset($__componentOriginal88b1a350664f7799b0ced566355c46e6); ?>
<?php endif; ?>
   </li>


    
    <div class="text-center d-none d-md-inline">
        <button class="rounded-corner border-0" id="sidebarToggle"></button>
    </div>
</ul><?php /**PATH C:\Users\richa\Desktop\EnglishLink_Project\resources\views/layouts/AreaInterna/sidebar.blade.php ENDPATH**/ ?>