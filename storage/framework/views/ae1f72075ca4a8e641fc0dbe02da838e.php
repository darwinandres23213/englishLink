<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'EnglishLink - Aprende Inglés'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', 'Academia de inglés líder en Colombia. Aprende inglés con profesores nativos y metodología innovadora.'); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/homepage.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public-pages.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <?php echo $__env->make('layouts.AreaPublica.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make('layouts.AreaPublica.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script src="<?php echo e(asset('js/homepage.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\DELL\Documents\EnglishLink_Project\resources\views/layouts/AreaPublica/appPagepublic.blade.php ENDPATH**/ ?>