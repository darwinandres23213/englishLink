<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'Panel'); ?></title>

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"> <!-- Iconos Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!-- Versión minificada de Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> <!-- Flatpickr (calendario/selector de fechas) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css"> <!-- Tema azul para el calendario -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!-- Iconos de font-awesome -->
    



    
    <link rel="stylesheet" href="<?php echo e(asset('css/sb-admin-2.min.css')); ?>"> <!-- Archivo CSS | SB Admin 2 -->
    <link rel="stylesheet" href="<?php echo e(asset('css/SidebarAreaInterna.css')); ?>"> <!-- CSS personalizado del Sidebar -->
    <link rel="stylesheet" href="<?php echo e(asset('css/TopbarAreaInterna.css')); ?>"> <!-- CSS personalizado del Topbar -->

    
    
    
    



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php echo $__env->yieldPushContent('styles'); ?>

</head>
<body id="page-top">
    <div id="wrapper">
        <?php echo $__env->make('layouts.AreaInterna.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php echo $__env->make('layouts.AreaInterna.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <main class="py-4">
                    <!-- Mensajes de error/éxito -->
                    <?php if(session('error')): ?>
                        <div class="container mt-3">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 1rem;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo e(session('error')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(session('success')): ?>
                        <div class="container mt-3">
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 1rem;">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php echo $__env->yieldContent('content'); ?>
                </main>
                <?php echo $__env->make('layouts.AreaInterna.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            
        </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    
    <!-- <script> // ✅ Mejorar la UX del menú lateral
        document.addEventListener('DOMContentLoaded', function() {
            // ✅ Mantener menú abierto según la ruta actual
            const currentPath = window.location.pathname;
            
            // Si estamos en páginas de pagos o medios de pago, mantener el menú abierto
            if (currentPath.includes('/pagos') || currentPath.includes('/mediopago') || 
                currentPath.includes('/asignacion-actividades') || currentPath.includes('/historial_imagenes')) {
                
                const collapseElement = document.getElementById('collapselinksInstructor');
                if (collapseElement) {
                    collapseElement.classList.add('show');
                }
                
                // Quitar clase collapsed del enlace padre
                const parentLink = document.querySelector('[data-target="#collapselinksInstructor"]');
                if (parentLink) {
                    parentLink.classList.remove('collapsed');
                    parentLink.setAttribute('aria-expanded', 'true');
                }
            }
            
            // ✅ Prevenir cierre automático al hacer clic en elementos activos
            document.querySelectorAll('.collapse-item.active').forEach(function(item) {
                item.addEventListener('click', function(e) {
                    // No prevenir la navegación, solo evitar el collapse
                    const parentCollapse = this.closest('.collapse');
                    if (parentCollapse) {
                        parentCollapse.classList.add('show');
                    }
                });
            });
        });
    </script> -->
</body>
</html><?php /**PATH C:\Users\richa\Desktop\EnglishLink_Project\resources\views/layouts/AreaInterna/app.blade.php ENDPATH**/ ?>