<?php $__env->startSection('title', 'Usuarios'); ?>
<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Usuarios</h1>

    
    <div class="mb-3">
        <a href="<?php echo e(route('usuarios.create')); ?>" class="btn btn-primary">Nuevo Usuario</a>
    </div>

    
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-sliders"> Filtros </i>
            </span>
            <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="false" aria-controls="filtrosCollapse">
                <i class="bi bi-funnel">Mostrar/Ocultar</i>
            </button>
        </div>
        
        <div class="collapse<?php echo e((request()->except(['page']) ? ' show' : '')); ?>" id="filtrosCollapse">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('usuarios.index')); ?>" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Escriba el nombre del usuario..." value="<?php echo e(request('nombre')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Apellido</label>
                        <input type="text" name="apellido" class="form-control" placeholder="Escriba el apellido del usuario..." value="<?php echo e(request('apellido')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Escriba el correo electrónico..." value="<?php echo e(request('email')); ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Rol</label>
                        <select name="rol" class="form-select">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($rol->id_rol); ?>" <?php echo e(request('rol') == $rol->id_rol ? 'selected' : ''); ?>>
                                    <?php echo e($rol->nombre_rol); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estado->id_estado); ?>" <?php echo e(request('estado') == $estado->id_estado ? 'selected' : ''); ?>>
                                    <?php echo e($estado->nombre_estado); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-6 d-flex gap-1">
                        <button type="submit" class="btn btn-primary mt-4">
                            <i class="bi bi-search"> Buscar</i>
                        </button>
                        <a href="<?php echo e(route('usuarios.index')); ?>" class="btn btn-secondary mt-4">
                            <i class="bi bi-x-circle"> Limpiar filtros</i>
                        </a>
                        <a href="#" class="btn btn-danger mt-4">
                            <i class="bi bi-file-earmark-pdf"> PDF</i>
                        </a>
                        <a href="#" class="btn btn-success mt-4">
                            <i class="bi bi-file-earmark-excel"> Excel</i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Imagen</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($usuario->id_usuario); ?></td>
                        <td><?php echo e($usuario->nombre); ?></td>
                        <td><?php echo e($usuario->apellido); ?></td>
                        <td><?php echo e($usuario->email); ?></td>
                        <td><?php echo e($usuario->rol->nombre_rol ?? 'N/A'); ?></td>

                        <td class="text-center"> 
                            
                            <span class="badge 
                                <?php switch($usuario->estado->nombre_estado ?? ''):
                                    case ('Activo'): ?>
                                        bg-success
                                        <?php break; ?>
                                    <?php case ('Inactivo'): ?>
                                        bg-secondary
                                        <?php break; ?>
                                    <?php case ('Suspendido'): ?>
                                        bg-danger
                                        <?php break; ?>
                                    <?php case ('Pendiente'): ?>
                                        bg-warning
                                        <?php break; ?>
                                    <?php default: ?>
                                        bg-secondary
                                <?php endswitch; ?>
                            " style="min-width: 80px; display: inline-block; text-align: center;">
                                <?php echo e($usuario->estado->nombre_estado ?? 'N/A'); ?>

                            </span>
                        </td>

                        <td class="text-center"> 
                            
                            <?php if($usuario->imagen): ?>
                                <img src="<?php echo e(asset('uploads/' . $usuario->imagen)); ?>" alt="Imagen" width="40" height="40" class="rounded-circle">
                            <?php else: ?>
                                <span class="text-muted">Sin imagen</span>
                            <?php endif; ?>
                        </td>

                        
                        <td class="text-center"> 
                            <a href="<?php echo e(route('usuarios.show', $usuario)); ?>" class="btn btn-sm btn-outline-info" title="Ver Detalle">
                                <i class="bi bi-search"></i>
                            </a>
                            <a href="<?php echo e(route('usuarios.edit', $usuario)); ?>" class="btn btn-sm btn-outline-primary" title="Editar Usuario">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="<?php echo e(route('usuarios.destroy', $usuario)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este usuario?')" title="Eliminar Usuario">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($usuarios->isEmpty()): ?>
                    <tr>
                        <td colspan="8" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="row mt-3">
        <div class="col-md-12 text-end">
            <?php echo e($usuarios->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.AreaInterna.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\richa\Desktop\EnglishLink_Project\resources\views/usuarios/index.blade.php ENDPATH**/ ?>