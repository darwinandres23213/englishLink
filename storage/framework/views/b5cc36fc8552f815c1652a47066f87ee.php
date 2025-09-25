<!-- Header -->
<header class="header">
    <nav class="navbar">
        <div class="nav-brand">
            <a href="<?php echo e(route('welcome')); ?>">
                <img src="<?php echo e(asset('img/inicio.png')); ?>" alt="EnglishLink Logo" class="logo">
                <span>EnglishLink</span>
            </a>
        </div>
        <ul class="nav-menu">
            <li><a href="<?php echo e(route('welcome')); ?>" class="nav-link <?php echo e(request()->routeIs('welcome') ? 'active' : ''); ?>">Inicio</a></li>
            <li><a href="<?php echo e(route('public.about')); ?>" class="nav-link <?php echo e(request()->routeIs('public.about') ? 'active' : ''); ?>">Nosotros</a></li>
            <li><a href="<?php echo e(route('public.courses')); ?>" class="nav-link <?php echo e(request()->routeIs('public.courses') ? 'active' : ''); ?>">Cursos</a></li>
            <li><a href="<?php echo e(route('public.contact')); ?>" class="nav-link <?php echo e(request()->routeIs('public.contact') ? 'active' : ''); ?>">Contacto</a></li>
            <li><a href="<?php echo e(route('login')); ?>" class="nav-link login-btn">Ingresar</a></li>
        </ul>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>
</header>
<?php /**PATH C:\Users\DELL\Documents\EnglishLink_Project\resources\views/layouts/AreaPublica/header.blade.php ENDPATH**/ ?>