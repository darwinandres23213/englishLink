
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro - English Link</title>
    <link rel="icon" href="<?php echo e(asset('img/Regis.png')); ?>">
    <link href="<?php echo e(asset('vendor/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('css/sb-admin-2.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: url('<?php echo e(asset('img/EL_Register.jpg')); ?>') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
        }
        .container {
            position: relative;
            max-width: 600px;
            width: 90%;
            animation: fadeIn 1s ease-in-out;
            padding: 15px;
            box-shadow: 0px 0 50px rgb(62, 92, 153, 1);
            border-radius: 10px;
            overflow: hidden;
            z-index: 1;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgb(255, 224, 91);
            transition: all 1s ease;
        }



        .logo-container {
            display: flex;
            justify-content: left;
            align-items: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 50px;
            height: auto;
            margin-right: 10px;
        }
        .logo-text {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }



        .password-container {
            position: relative;
        }
        .password-container .toggle-password {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgb(0, 0, 0);
            font-size: 18px;
            transition: color 0.3s ease;
        }
        .password-container .toggle-password:hover {
            color: rgb(255, 0, 0);
        }



        h1.h4 {
            font-size: 30px;
            font-weight: bold;
            color: rgb(255, 255, 255);
            margin-bottom: 15px;
            font-family: 'Arial', sans-serif;
            text-align: left;
        }



        .card {
            background: linear-gradient(90deg, rgb(0, 0, 0), rgb(255, 224, 91));
            background-size: 200% 200%;
            animation: gradientAnimation 10s ease infinite;
            box-shadow: 0 0 50px 5px rgb(0, 0, 0, 0.4);
            border-radius: 10px;
        }



        .form-control-user {
            border: 1px rgb(228, 228, 228, 0.5);
            /*background: rgba(255, 255, 255, 0.9);*/
            border-radius: 10px;
            /*padding: 12px 20px;*/
            font-size: 16px;
            background-color: transparent;
            color:rgb(255, 255, 255); /* Color del texto */
            transition: border-color 0.4s ease, background-color 0.3s ease;
            height: 50px; /* Altura del campo de entrada */
            /*transition: all 0.3s ease;
            backdrop-filter: blur(5px);*/
        }
        .form-control-user:hover { /*Botones Email y Password*/
            border: 1px solid rgb(228, 228, 228, 0.5);
            font-size: 16px;
            /*background: rgba(255, 255, 255, 1);*/
            background-color: transparent;
            color: rgb(255, 255, 255);
            font-weight: bold !important;
            transition: border-color 0.4s ease, background-color 0.3s ease;
            /*border-color: rgb(255, 224, 91);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 224, 91, 0.3);*/
        }
        .form-control-user::placeholder {
            color: #dddddd;
            font-size: 15px;
            opacity: 1;
            /*font-weight: 500;*/
        }
        .form-control-user:focus {
            border: 4px solid rgb(228, 228, 228, 0.5);
            border-color: rgb(255, 224, 91);
            background-color: rgb(255, 255, 255, 0.5);
            /*background: rgba(255, 255, 255, 1);*/
            outline: none;
            color: rgb(0, 0, 0);
            font-size: 18px;
            transition: all 0.3s ease;
            box-shadow: 0px 3px 0px rgb(255, 0, 0);
        }

        select.form-control-user { /* Estilo para el select 'ROLES'*/
            border: none !important; /* border: 1px solid rgb(228, 228, 228, 0.5) !important; */
            border-radius: 10px !important;
            font-size: 16px !important;
            background-color: transparent !important;
            color: rgb(255, 255, 255) !important;
            transition: border-color 0.4s ease, background-color 0.3s ease;
            height: 50px !important;
            /*padding: 12px 15px !important;*/

            appearance: none; /* Quita la flecha nativa */
            -webkit-appearance: none; /* Quita la flecha nativa en Safari */
            -moz-appearance: none; /* Quita la flecha nativa en Firefox */
            /*box-shadow: none !important;*/
        }
        select.form-control-user:hover {
            border: 1px solid rgb(228, 228, 228, 0.5) !important;
            font-size: 16px !important;
            background-color: transparent !important;
            color: rgb(255, 255, 255, 0.9) !important;
            font-weight: bold !important;
            transition: border-color 0.4s ease, background-color 0.3s ease;
        }
        select.form-control-user::placeholder { /* Placeholder del select */
            color: #dddddd !important;
            font-size: 15px !important;
            opacity: 1 !important;
        }
        select.form-control-user:focus {
            border: 4px solid rgb(228, 228, 228, 0.5) !important;
            border-color: rgb(255, 224, 91) !important;
            background-color: rgb(255, 255, 255, 0.5) !important;
            outline: none !important;
            color: rgb(0, 0, 0) !important;
            /*font-size: 18px !important;*/
            transition: all 0.3s ease !important;
            box-shadow: 0px 3px 0px rgb(255, 0, 0) !important;
        }
        select.form-control-user option {
            color: #000;
            background: rgb(255, 224, 91);
            /*font-weight: bold !important;*/
        }



        .btn-success { /* Botón de registro 'Crear Cuenta' */
            /*background: linear-gradient(45deg, rgb(40, 167, 69), rgb(25, 135, 84));*/
            /*background: rgb(255, 0, 0);*/
            background: transparent;
            border: 1px solid rgb(255, 255, 255);
            width: 44%;
            margin-top: 10px; /* Centra el botón horizontalmente */
            font-size: 16px;
            /*margin-top: 10px;*/
            color: #ffffff;
            /*border: none;*/
            border-radius: 10px;
            height: 44px;
            transition: background-color 0.3s ease;
            /*padding: 12px 30px;*/
            letter-spacing: 1px;
            /*font-weight: bold;*/
            /*text-transform: uppercase;*/
        }
        .btn-success:hover {
            color:rgb(0, 0, 0);
            background-color: rgb(255, 208, 0);
            box-shadow: 0 0px 25px 8px rgb(255, 208, 0);
            font-weight: bold;
            border: none;
            width: 50%;
            font-size: 16px;
            transition: all 0.3s ease;
            /*background: linear-gradient(45deg, rgb(25, 135, 84), rgb(40, 167, 69));
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);*/
        }
        .btn-success:focus, 
        .btn-success:active, 
        .btn-success:focus:active { /* Botón al hacer click */
            outline: none !important;
            box-shadow: none !important;
        }
        .btn-success:active, .btn-success:focus:active { /* Botón al tener sostenido el click */
            background-color: rgb(255, 208, 0) !important;
            color: #ffffff !important;
            box-shadow: 0 0px 25px 8px rgb(255, 208, 0) !important;
            border: 1px solid rgb(255, 255, 255) !important;
        }


        
        .form-group {
            margin-bottom: 20px;
        }
        .btn-user { /* Botón de crear cuenta */
            display: block; /* Asegura que el botón sea un bloque */
            margin: 0 auto; /* Centra el botón horizontalmente */
            padding: 1px 1px; /* Ajusta el relleno interno */
            width: 50%; /* Ajusta el ancho del botón (opcional) */
        }



        .text-center a {
            color: #ffffff;
            text-decoration: none;
            margin-top: 0;
            display: inline-block;
            /*font-weight: bold;
            transition: color 0.3s ease;*/
        }
        .text-center a:hover {
            color: rgb(255, 255, 255);
            font-weight: bold;
            /*text-decoration: underline;*/
        }



        .login-text { /* Texto de '¿Ya tienes una cuenta?' */
            font-size: 14px; /* Tamaño del texto */
            color: #ffffff; /* Color del texto */
            font-family: 'Arial', sans-serif; /* Fuente del texto */
            margin-bottom: 5px; /* Reduce el margen inferior */
        }
        .login-text a { /* Texto de '¡Inicia sesión aquí!' */
            font-size: 15px;
            color: rgb(255, 255, 255);
            font-weight: bold;
            text-decoration: none; /* Elimina el subrayado */
            text-shadow: 0px 0px 15px rgb(255, 255, 255); /* Añade sombra al texto */
        }
        .login-text a:hover { /* ¡Inicia sesión aquí! */
            text-decoration: none; /* Añade subrayado al pasar el mouse */
            /*text-shadow: 0px 0px 15px rgb(255, 255, 255), 0px 0px 15px rgb(0, 0, 0);*/ /* Sombra blanca y negra */
            animation: hoverColor 7s ease infinite; /* Animación de cambio de color */
        }


        
        /* Estilos para las alertas */
        .alert {
            border: 1px solid rgb(255, 255, 255) !important;
            border-radius: 10px;
            margin-bottom: 1px;
            text-align: center;
            margin-top: 50px;
        }
        .alert-danger {
            background: rgba(255, 0, 25, 0.9);
            border: none;
            color: white;
            box-shadow: 0 0 20px 10px rgba(255, 0, 25);
        }
        /*.alert-success {
            background: rgba(40, 167, 69, 0.9);
            border: none;
            color: white;
            box-shadow: 0 0 20px 10px rgba(40, 167, 69);
        }*/



        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes hoverColor { /* Animación de '.login-text a:hover' */
            0% {
                color: rgb(255, 255, 255); /* Rojo */
                text-shadow: 0px 0px 5px 20px rgb(0, 0, 0), 0px 0px 5px 20px rgb(255, 255, 255);
            }
            50% {
                color: #000000; /* Blanco */
                text-shadow: 0px 0px 5px 20px rgb(255, 255, 255), 0px 0px 5px 20px rgb(0, 0, 0);
            }
            100% {
                color: rgb(255, 255, 255); /* Rojo */
                text-shadow: 0px 0px 5px 20px rgb(0, 0, 0), 0px 0px 5px 20px rgb(255, 255, 255);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card o-hidden border-0">
            <div class="card-body p-5">
                <div class="logo-container text-center">
                    <img src="<?php echo e(asset('img/ama.png')); ?>" alt="Logo" class="logo">
                    <span class="logo-text">English Link</span>
                </div>
                <h1 class="h4 mb-4">¡Crea una cuenta!</h1>

                <form method="POST" action="<?php echo e(route('register')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="nombre" class="form-control form-control-user" 
                                       placeholder="Nombres" 
                                       value="<?php echo e(old('nombre')); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="apellido" class="form-control form-control-user" 
                                       placeholder="Apellidos" 
                                       value="<?php echo e(old('apellido')); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" class="form-control form-control-user" 
                               placeholder="Correo Electrónico" 
                               value="<?php echo e(old('email')); ?>" required>
                    </div>

                    <!-- <div class="form-group">
                        <select name="rol_id" class="form-control form-control-user" required>
                            <option value="">Selecciona tu rol</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($rol->id_rol); ?>" 
                                        <?php echo e(old('rol_id') == $rol->id_rol ? 'selected' : ''); ?>>
                                    <?php echo e($rol->nombre_rol); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div> -->

                    <div class="form-group">
                        <select name="rol_id" class="form-control form-control-user" required>
                            <option value="">Selecciona tu rol</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($rol->id_rol); ?>" 
                                        <?php echo e(old('rol_id') == $rol->id_rol ? 'selected' : ''); ?>>
                                    <?php echo e($rol->nombre_rol); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group password-container">
                                <input type="password" name="password" id="password" 
                                       class="form-control form-control-user" 
                                       placeholder="Contraseña" required>
                                <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group password-container">
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="form-control form-control-user" 
                                       placeholder="Confirmar Contraseña" required>
                                <i class="fas fa-eye toggle-password" id="togglePasswordConfirm"></i>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-user btn-block">Crear Cuenta</button>
                </form>

                <hr> <!-- Línea horizontal (<hr style="border-color: rgba(255, 255, 255, 0.3);">) -->
                <div class="text-center">
                    <p class="login-text">
                        ¿Ya tienes una cuenta? 
                        <a href="<?php echo e(route('login')); ?>">
                            ¡Inicia sesión aquí!
                        </a>
                    </p>
                </div>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo e($error); ?><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Funcionalidad del ojito para contraseña
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#password');

        if (togglePassword && passwordField) {
            togglePassword.addEventListener('click', function () {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        // Funcionalidad del ojito para confirmar contraseña
        const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
        const passwordConfirmField = document.querySelector('#password_confirmation');

        if (togglePasswordConfirm && passwordConfirmField) {
            togglePasswordConfirm.addEventListener('click', function () {
                const type = passwordConfirmField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmField.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }



        // 🔥 NUEVO: SweetAlert para registro exitoso (sin botones, solo timer)
        <?php if(session('registro_exitoso')): ?>
            Swal.fire({
                title: '¡Registro Exitoso! 🎉',
                html: `
                    <div style="text-align: center;">
                        <i class="fas fa-user-check" style="font-size: 60px; color: #28a745; margin-bottom: 15px;"></i>
                        <h3 style="color: #28a745; margin-bottom: 10px;">¡Bienvenido, <?php echo e(session('usuario_nombre')); ?>!</h3>
                        <p style="font-size: 16px; margin-bottom: 10px;">Tu cuenta ha sido creada exitosamente.</p>
                        <p style="font-size: 14px; color: #666;">
                            <strong>Email:</strong> <?php echo e(session('usuario_email')); ?>

                        </p>
                        <hr style="margin: 15px 0;">
                        <p style="font-size: 14px; color: #666;">
                            Serás redirigido al login en <strong id="countdown">5</strong> segundos...
                        </p>
                        <div style="margin-top: 15px;">
                            <div style="background: #e9f7ef; padding: 10px; border-radius: 8px; border-left: 4px solid #28a745;">
                                <small style="color: #155724;">
                                    <i class="fas fa-info-circle"></i> 
                                    Ahora puedes iniciar sesión con tus credenciales
                                </small>
                            </div>
                        </div>
                    </div>
                `,
                icon: 'success',
                showConfirmButton: false, // 🔥 Sin botones
                showCancelButton: false,  // 🔥 Sin botones
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 5000, // 5 segundos
                timerProgressBar: true,
                customClass: {
                    popup: 'registro-exitoso-popup',
                    title: 'registro-exitoso-title',
                    htmlContainer: 'registro-exitoso-content'
                },
                didOpen: () => {
                    // Contador regresivo
                    let countdown = 5;
                    
                    const timerInterval = setInterval(() => {
                        countdown--;
                        const countdownElement = document.getElementById('countdown');
                        if (countdownElement) {
                            countdownElement.textContent = countdown;
                        }
                        
                        if (countdown <= 0) {
                            clearInterval(timerInterval);
                        }
                    }, 1000);
                }
            }).then((result) => {
                // Cuando el timer termine, redirigir al login
                if (result.dismiss === Swal.DismissReason.timer) {
                    // 🔥 Redirigir al login con el email ya prellenado
                    window.location.href = "<?php echo e(route('login')); ?>"; /* "<?php echo e(route('login')); ?>?email=<?php echo e(urlencode(session('usuario_email'))); ?>" */
                }
            });
        <?php endif; ?>
    </script>
</body>
</html><?php /**PATH C:\Users\DELL\Documents\EnglishLink_Project\resources\views/auth/register.blade.php ENDPATH**/ ?>