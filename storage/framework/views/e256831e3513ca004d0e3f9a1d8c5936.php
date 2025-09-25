

<?php 
    $usuario = Auth::user(); 
?>

<li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-white small text-uppercase font-weight-bold">
            <?php echo e($usuario->nombre_completo ?? 'Usuario'); ?>

        </span>
    <img class="img-profile rounded-circle" src="<?php echo e($usuario->url_imagen_perfil); ?>" alt="Profile Picture" width="35" height="35">
    </a>
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in mt-2" aria-labelledby="userDropdown" style="min-width: 220px;">
        <div class="text-center p-2">
            <p class="text-gray-600 mb-1" title="<?php echo e($usuario->email ?? 'correo@ejemplo.com'); ?>">
                <span><?php echo e($usuario->email ?? 'correo@ejemplo.com'); ?></span>
            </p>
            <div class="dropdown-divider"></div>
            <img class="img-profile rounded-circle mb-2" src="<?php echo e($usuario->url_imagen_perfil); ?>" alt="Profile Picture" width="70" height="70">
            <h6 class="text-gray-600 font-weight-bold">
                <?php echo e($usuario->nombre_completo ?? 'Usuario de English Link'); ?>

            </h6>
        </div>
        <a class="dropdown-item text-gray-600" href="<?php echo e(route('profile')); ?>">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-600"></i>
            Perfil
        </a>
        <a class="dropdown-item text-gray-600" href="#">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-600"></i>
            Configuración
        </a>
        

        <div class="dropdown-divider"></div>

        <?php if (isset($component)) { $__componentOriginal88b1a350664f7799b0ced566355c46e6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88b1a350664f7799b0ced566355c46e6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.Boton-LogOut','data' => ['variant' => 'para_dropdown']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('Boton-LogOut'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'para_dropdown']); ?>
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

    </div>
</li>
<?php /**PATH C:\Users\richa\Desktop\EnglishLink_Project\resources\views/components/MenUser-topbar-AI.blade.php ENDPATH**/ ?>