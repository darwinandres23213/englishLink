<?php $__env->startSection('title', 'Historial de Imágenes'); ?>
<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    
<?php endif; ?>

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <h1 class="mb-4 fw-bold">Historial de Imágenes</h1>

    <div class="mb-3">
        <a href="<?php echo e(route('historial_imagenes.create')); ?>" class="btn btn-primary mb-3 mb-md-0">Subir Nueva Imagen</a>
    </div>

      

    <div class="table-responsive rounded shadow-sm" style="background: #fff;">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Imagen</th>
                    <th>Fecha de Subida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $imagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="text-center">
                        <td><?php echo e($imagen->id); ?></td>
                        <td><?php echo e($imagen->usuario_id); ?></td>
                        <td>
                            <?php
                                $ruta = public_path('uploads/' . $imagen->nombre_imagen);
                            ?>
                            <?php if(file_exists($ruta)): ?>
                                <img src="<?php echo e(asset('uploads/' . $imagen->nombre_imagen)); ?>" alt="Imagen" width="60">
                            <?php else: ?>
                                <span class="text-muted">Sin imagen</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($imagen->fecha_subida ?? $imagen->created_at); ?></td>
                        <td>
                            <a href="<?php echo e(asset('uploads/' . $imagen->nombre_imagen)); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye" title="Ver Imagen"></i>
                            </a>
                            <form action="<?php echo e(route('historial_imagenes.destroy', $imagen->id)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta imagen?')">
                                    <i class="bi bi-trash" title="Eliminar Imagen"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 text-end">
            <?php echo e($imagenes->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.AreaInterna.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\richa\Desktop\EnglishLink_Project\resources\views/historial_imagenes/index.blade.php ENDPATH**/ ?>