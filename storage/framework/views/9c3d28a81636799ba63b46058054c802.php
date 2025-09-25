<?php $__env->startSection('title', 'Perfil de Usuario'); ?>
<?php $__env->startSection('content'); ?>

<div class="container py-4" style="background: #f8f9fc; min-height: 70vh; border-radius: 12px;">
    <div class="mb-4">
        <h1 class="fw-bold">
            <i class="bi bi-person-bounding-box me-3"></i>Mi Perfil
        </h1>
        
    </div>

    <div class="row g-4">
        <!-- Información del Usuario -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <img class="img-profile rounded-circle mb-1"
                        src="<?php echo e($usuario->url_imagen_perfil); ?>"
                        alt="Profile Picture"
                        width="120"
                        style="cursor:pointer"
                        data-bs-toggle="modal"
                        data-bs-target="#modalPrevisualizacion">
                    <h4 class="mb-4"><?php echo e($usuario->nombre); ?> <?php echo e($usuario->apellido); ?></h4>
                    <p class="text-muted mb-1"><?php echo e($usuario->email); ?></p>
                    <p class="text-muted mb-1"><?php echo e($usuario->rol->nombre_rol ?? 'Sin rol'); ?></p>
                    <button class="btn btn-outline-primary btn-sm w-50 mt-4" 
                        data-bs-toggle="modal" 
                        data-bs-target="#editProfileModal">
                        Editar Perfil
                    </button>
                </div>
            </div>
        </div>

        <!-- Placeholder para futuras secciones (cursos, historial, etc.) -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-body text-center text-muted">
                    <i class="fas fa-user-circle fa-3x mb-3"></i>
                    <p>Próximamente: cursos inscritos, historial de imágenes y más opciones de perfil.</p>
                </div>
            </div>

            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary" id="toggleHistorial" style="cursor: pointer;">
                        Historial de Imágenes
                    </h6>
                </div>
                <div class="card-body" id="historialImagenes" style="display: none;">
                    <div class="row">
                        <?php
                            $imagenesFiltradas = collect($historialImagenes)
                                ->filter(function($img) {
                                    // Excluir imágenes que sean URLs (imagen por defecto)
                                    return !filter_var($img->nombre_imagen, FILTER_VALIDATE_URL);
                                })
                                ->sortByDesc('fecha_subida');
                        ?>
                        <?php if($imagenesFiltradas->isEmpty()): ?>
                            <p class="text-muted ml-3">No tienes imágenes en tu historial.</p>
                        <?php else: ?>
                            <?php $__currentLoopData = $imagenesFiltradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4 text-center mb-3">
                                    <img src="<?php echo e(asset('uploads/' . $imagen->nombre_imagen)); ?>" alt="Imagen Historial" class="img-thumbnail preview-img" width="100" style="cursor:pointer" onclick="previsualizarImagen('<?php echo e(asset('uploads/' . $imagen->nombre_imagen)); ?>')">
                                    <p class="text-muted small"><?php echo e($imagen->fecha_subida); ?></p>
                                    <!-- Botón para usar la imagen como perfil -->
                                    <form action="<?php echo e(route('profile.image.use')); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="imagen_historial" value="<?php echo e($imagen->nombre_imagen); ?>">
                                        <button type="submit" class="btn btn-primary btn-sm">Usar</button>
                                    </form>
                                    <!-- Botón para eliminar la imagen del historial -->
                                    <form action="<?php echo e(route('profile.image.delete')); ?>" method="POST" style="display:inline;" class="form-eliminar-imagen">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="imagen" value="<?php echo e($imagen->nombre_imagen); ?>">
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar-imagen">Eliminar</button>
                                    </form>
                                    <!-- Botón para descargar la imagen -->
                                    <a href="<?php echo e(asset('uploads/' . $imagen->nombre_imagen)); ?>" download class="btn btn-success btn-sm">Descargar</a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modalPrevisualizacion" tabindex="-1" aria-labelledby="modalPrevisualizacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-0">
                <?php if(!empty($historialImagenes)): ?>
                    <div class="row">
                        <?php $__currentLoopData = $historialImagenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imagen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-3 text-center mb-3">
                                <img src="<?php echo e(asset('uploads/' . $imagen->nombre_imagen)); ?>" alt="Imagen Historial" class="img-thumbnail" width="100">
                                <p class="text-muted small"><?php echo e($imagen->fecha_subida); ?></p>
                                <a href="<?php echo e(asset('uploads/' . $imagen->nombre_imagen)); ?>" download class="btn btn-success btn-sm">Descargar</a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <img 
                        src="<?php echo e($usuario->url_imagen_perfil); ?>" 
                        alt="Profile Picture" 
                        class="img-fluid">
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <form action="<?php echo e(route('profile.image')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="imagen">Cambiar Foto de Perfil</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
            
            <?php if($usuario->imagen && $usuario->imagen !== 'UsuarioSinPerfil.png' && !filter_var($usuario->imagen, FILTER_VALIDATE_URL)): ?>
            <form action="<?php echo e(route('profile.image.remove')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="quitar_perfil" value="1">
                <div class="modal-body">
                    <button type="submit" class="btn btn-danger w-100">Quitar Imagen del Perfil</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php if(session('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '<?php echo e(session('success')); ?>',
            timer: 2500,
            showConfirmButton: false
        });
    </script>
<?php endif; ?>


<?php if($errors->any()): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: `<?php echo implode('<br>', $errors->all()); ?>`,
            timer: 4000,
            showConfirmButton: false
        });
    </script>
<?php endif; ?>

<script>
    document.getElementById('toggleHistorial').addEventListener('click', function () {
        const historial = document.getElementById('historialImagenes');
        historial.style.display = historial.style.display === 'none' ? 'block' : 'none';
    });

    // Previsualización de imagen en historial
    function previsualizarImagen(url) {
        Swal.fire({
            imageUrl: url,
            imageAlt: 'Previsualización',
            showConfirmButton: false,
            width: 400,
            padding: '2em',
            background: '#f8f9fc',
        });
    }

    // Confirmación para eliminar imágenes (SweetAlert)
    document.querySelectorAll('.btn-eliminar-imagen').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('.form-eliminar-imagen');
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¡No podrás revertir esta acción!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                background: '#fff3cd',
                color: '#856404'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.AreaInterna.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\richa\Desktop\EnglishLink_Project\resources\views/profile.blade.php ENDPATH**/ ?>