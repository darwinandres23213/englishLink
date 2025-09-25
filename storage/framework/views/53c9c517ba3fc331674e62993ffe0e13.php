

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['variant' => 'dropdown']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['variant' => 'dropdown']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
</form>


<?php if($variant === 'para_sidebar'): ?>
    <button type="submit" form="logout-form" class="nav-link btn btn-link" style="text-decoration: none; width: 100%; text-align: left;">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Cerrar Sesión</span>
    </button>
<?php else: ?>
    
    <a class="dropdown-item text-gray-600" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-600"></i>
        Cerrar sesión
    </a>
<?php endif; ?><?php /**PATH C:\Users\richa\Desktop\EnglishLink_Project\resources\views/components/Boton-LogOut.blade.php ENDPATH**/ ?>