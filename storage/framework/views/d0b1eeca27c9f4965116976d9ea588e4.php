<nav class="navbar navbar-expand navbar-light bg-dark topbar mb-4 static-top shadow" style="padding: 0 1.5rem;">
    
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>


    <!-- Topbar Search -->
    


    <!-- Topbar Navbar | Menu de Usuario -->
    <ul class="navbar-nav ml-auto">
        <?php if (isset($component)) { $__componentOriginalc69127057a04effe073dc0e28745720b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc69127057a04effe073dc0e28745720b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.MenUser-topbar-AI','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('MenUser-topbar-AI'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc69127057a04effe073dc0e28745720b)): ?>
<?php $attributes = $__attributesOriginalc69127057a04effe073dc0e28745720b; ?>
<?php unset($__attributesOriginalc69127057a04effe073dc0e28745720b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc69127057a04effe073dc0e28745720b)): ?>
<?php $component = $__componentOriginalc69127057a04effe073dc0e28745720b; ?>
<?php unset($__componentOriginalc69127057a04effe073dc0e28745720b); ?>
<?php endif; ?> <!-- Nav Item - User Information -->
    </ul>
</nav><?php /**PATH C:\Users\richa\Desktop\EnglishLink_Project\resources\views/layouts/AreaInterna/topbar.blade.php ENDPATH**/ ?>