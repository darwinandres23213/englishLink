{{-- filepath: resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Iniciar Sesión🗝️| English Link</title>
    <link rel="icon" href="{{ asset('img/EL3.png') }}">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/homepage.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            padding-top: 80px; /* Espacio para el header */
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Background Slider para Login */
        .login-bg-slider {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        
        .login-bg-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }
        
        .login-bg-slide.active {
            opacity: 1;
        }
        
        .login-bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(0, 0, 0) 0%, 
                rgba(0, 0, 0, 0.9) 70%, 
                rgba(0, 0, 0, 0.8) 100%
            );
        }
        
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px);
            padding: 20px;
            position: relative;
            z-index: 1;
        }
        
        /* Responsive para el header en login */
        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }
            .login-container {
                min-height: calc(100vh - 70px);
                padding: 10px;
            }
        }
        .container {
            position: relative;
            max-width: 500px;
            width: 90%;
            animation: fadeIn 1s ease-in-out;
            padding: 25px;
            box-shadow: 0px 0 40px rgba(0, 0, 0, 0.4), 
                        0px 0 80px rgba(59, 130, 246, 0.2);
            border-radius: 15px;
            overflow: hidden;
            z-index: 10;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.8s ease;
        }
        
        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 50px rgba(0, 0, 0, 0.5), 
                        0px 0 100px rgba(59, 130, 246, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.25);
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
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #dddddd;
            font-size: 18px;
            transition: color 0.3s ease;
        }
        .password-container .toggle-password:hover {
            color:rgb(17, 0, 255);
        }



        h1.h4 {
            font-size: 30px;
            font-weight: bold;
            color: rgb(255, 255, 255);
            text-shadow: none;
            margin-bottom: 15px;
            font-family: 'Arial', sans-serif;
            text-align: left;
        }



        .card {
            background: linear-gradient(90deg, rgba(59, 131, 246),rgb(245, 59, 59));
            background-size: 200% 200%;
            animation: gradientAnimation 5s ease infinite;
            box-shadow: 0 0 50px 5px rgba(0, 0, 0, 0.4);
            border-radius: 10px;
        }



        .form-control-user {
            /*background: rgba(255, 255, 255, 0.9);*/
            border: 1px rgb(228, 228, 228, 0.5);
            border-radius: 10px !important;
            padding: 12px 15px !important;
            font-size: 16px;
            background-color: transparent;
            color: #000;
            transition: border-color 0.4s ease, background-color 0.3s ease;
            height: 50px; /* Altura del campo de entrada */
            /*backdrop-filter: blur(5px);*/
        }
        .form-control-user:hover {
            border: 1px solid rgb(228, 228, 228, 0.5);
            font-size: 16px;
            background-color: transparent;
            color: rgb(0, 0, 0); /* Cambia el color del texto */
            transition: border-color 0.4s ease, background-color 0.3s ease;
            /*transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 224, 91, 0.3);*/
        }
        .form-control-user::placeholder {
            color: #dddddd;
            /*font-weight: bold;*/
            font-size: 15px;
            opacity: 1; /* Reduce la opacidad del placeholder */
        }
        .form-control-user:focus {
            border: 4px solid rgb(228, 228, 228, 0.5);
            border-color:rgba(0, 98, 255, 0.4);
            background-color: rgba(221, 221, 221, 0.2); /*color al ingresar un dato!*/
            outline: none;
            color: #000; /* Cambia el color del texto al enfocar */
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0px 4px 4px rgb(243, 0, 0, 0.7);
        }



        .btn-primary {
            border: 1px solid rgb(255, 255, 255);
            background: transparent; /* rgba(59, 131, 246) */
            width: 100%;
            margin-top: 10px;
            /*border: none;*/
            border-radius: 10px;
            /*padding: 12px 30px;*/
            font-size: 16px;
            /*font-weight: bold;*/
            height: 44px; /* Altura del botón */
            color: #ffffff;
            transition: background-color 0.3s ease;
            /*text-transform: uppercase;
            letter-spacing: 1px;*/
        }
        .btn-primary:hover {
            background: rgb(255, 0, 0);
            border: 2px solid rgb(255, 255, 255);
            font-weight: bold;
            width: 50%;
            /*font-size: 16px;*/
            transition: all 0.3s ease;
            /*transform: translateY(-3px);*/
            box-shadow: 0 0px 25px 8px rgb(255, 0, 0);
            /*color: #000;*/
            font-style: italic; /* Letra en cursiva */
        }
        .btn-primary:focus, 
        .btn-primary:active, 
        .btn-primary:focus:active { /* Botón al hacer click */
            outline: none !important;
            box-shadow: none !important;
        }
        .btn-primary:active, 
        .btn-primary:focus:active { /* Botón al tener sostenido el click */
            background-color: rgb(255, 0, 0) !important;
            color: #ffffff !important;
            box-shadow: 0 0px 25px 8px rgb(255, 0, 0) !important;
            border: 2px solid rgb(255, 255, 255) !important;
        }



        .form-group {
            margin-bottom: 20px;
        }
        .btn-user { /* Botón de inicio de sesión */
            display: block; /* Asegura que el botón sea un bloque */
            margin: 0 auto; /* Centra el botón horizontalmente */
            padding: 1px 1px; /* Ajusta el relleno interno */
            width: 50% !important; /* Ajusta el ancho del botón (opcional) */
        }



        .text-center a { /* Enlaces de texto centrado '¿Olvidaste tu contraseña?' */
            font-size: 14px;
            color: #ffffff;
            text-decoration: none;
            margin-top: 0;
            display: inline-block;
            /*font-weight: bold;
            transition: color 0.3s ease;*/
        }
        .text-center a:hover {
            color: rgb(251, 255, 0);
            text-shadow: 0px 0px 15px rgb(251, 255, 0); /* Añade sombra al texto */
            font-weight: bold;
            /*text-decoration: underline;*/
        }



        .register-text { /* Texto de registro '¿No tienes una cuenta?' */
            font-size: 14px;
            /*text-align: center;
            margin-top: 20px;*/
            color: rgb(255, 255, 255);
            font-family: 'Arial', sans-serif;
            margin-bottom: 5px;
        }
        


        .register-text a { /* Enlace de registro '¡Regístrate aquí!' */
            color: rgb(255, 255, 255);
            font-weight: bold;
            font-size: 15px;
            text-decoration: none;
            /*transition: color 0.3s ease;*/
        }
        .register-text a:hover {
            /*font-size: 15px;*/ /* Cambia el tamaño al pasar el mouse */
            color:rgb(251, 255, 0); /* Cambia el color al pasar el mouse */
            text-decoration: none; /* Añade subrayado al pasar el mouse */
            text-shadow: 0px 0px 10px rgb(251, 255, 0); /* Añade sombra al texto */
            /*text-decoration: underline;*/
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
        .alert-success {
            background: rgba(40, 167, 69, 0.9);
            border: none;
            color: white;
            box-shadow: 0 0 20px 10px rgba(40, 167, 69);
        }



        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
            h1.h4 {
                font-size: 24px;
            }
            /* Falta estilos del Dashboard_tarea */
        }

        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(-20px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes borderGlow {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }




        /* 🔥 CORREGIDO: Estilos personalizados para SweetAlert de logout exitoso */
        .logout-exitoso-popup {
            border-radius: 15px !important;
            padding: 15px !important; /* Reducido el padding */
            max-width: 450px !important; /* Controlar el ancho máximo */
            width: auto !important;
        }
        .logout-exitoso-title {
            font-size: 22px !important; /* Reducido ligeramente */
            font-weight: bold !important;
            color: #28a745 !important;
            margin-bottom: 10px !important; /* Reducir margen inferior */
        }
        .logout-exitoso-content {
            font-size: 14px !important; /* Reducido el tamaño de fuente */
            padding: 10px !important; /* Reducir padding del contenido */
            margin: 0 !important;
        }
        .swal2-timer-progress-bar {
            background: #28a745 !important;
        }
        .swal2-popup {
            animation: swal2-show 0.3s ease-out !important;
        }
        
        /* 🔥 NUEVO: Estilos específicos para hacer el popup más compacto */
        .logout-exitoso-popup .swal2-header {
            padding: 15px 20px 5px 20px !important; /* Reducir padding del header */
        }
        .logout-exitoso-popup .swal2-content {
            padding: 0 20px 15px 20px !important; /* Reducir padding del contenido */
        }
        .logout-exitoso-popup .swal2-icon {
            margin: 10px auto 15px auto !important; /* Reducir márgenes del icono */
        }
        
        /* Animación personalizada */
        @keyframes swal2-show {
            0% {
                transform: scale(0.7) translateY(-100px);
                opacity: 0;
            }
            100% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Background Slider -->
    <div class="login-bg-slider">
        <div class="login-bg-slide active" style="background-image: url('{{ asset('img/EL_fotor.jpg') }}')">
            <div class="login-bg-overlay"></div>
        </div>
        <!-- <div class="login-bg-slide" style="background-image: url('{{ asset('img/Wow.jpg') }}')">
            <div class="login-bg-overlay"></div>
        </div>
        <div class="login-bg-slide" style="background-image: url('{{ asset('img/Img2.jpg') }}')">
            <div class="login-bg-overlay"></div>
        </div>
        <div class="login-bg-slide" style="background-image: url('{{ asset('img/Img3.jpg') }}')">
            <div class="login-bg-overlay"></div>
        </div>
        <div class="login-bg-slide" style="background-image: url('{{ asset('img/Img4.jpg') }}')">
            <div class="login-bg-overlay"></div>
        </div> -->
    </div>

    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="nav-brand">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('img/inicio.png') }}" alt="EnglishLink Logo" class="logo">
                    <span>EnglishLink</span>
                </a>
            </div>
            <ul class="nav-menu">
                <li><a href="{{ route('welcome') }}" class="nav-link">Inicio</a></li>
                <li><a href="{{ route('public.about') }}" class="nav-link">Nosotros</a></li>
                <li><a href="{{ route('public.courses') }}" class="nav-link">Cursos</a></li>
                <li><a href="{{ route('public.contact') }}" class="nav-link">Contacto</a></li>
                <li><a href="{{ route('login') }}" class="nav-link login-btn active">Ingresar</a></li>
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <div class="login-container">
        <div class="container">
        <div class="card o-hidden border-0">
            <div class="card-body p-5"> <!-- Cambiado a p-5 para más espacio -->
                <div class="logo-container text-center">
                    <img src="{{ asset('img/ama.png') }}" alt="Logo" class="logo">
                    <span class="logo-text">English Link</span>
                </div>
                <h1 class="h4">Iniciar Sesión</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" class="form-control form-control-user" 
                               placeholder="Correo electrónico" 
                               value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group password-container">
                        <input type="password" name="password" id="password" 
                               class="form-control form-control-user" 
                               placeholder="Contraseña" required>
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                    </div>

                    <!-- Checkbox "Recordarme" -->
                    {{-- <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" name="remember" class="custom-control-input" id="remember">
                            <label class="custom-control-label text-white" for="remember">
                                Recordarme
                            </label>
                        </div>
                    </div> --}}

                    <button type="submit" class="btn btn-primary btn-user btn-block">Iniciar Sesión</button>
                </form>

                <hr> <!-- Línea horizontal (<hr style="border-color: rgba(255, 255, 255, 0.7);">) -->
                <div class="text-center">
                    <p class="register-text">
                        ¿No tienes una cuenta? <a href="{{ route('register') }}">¡Regístrate aquí!</a>
                    </p>
                </div>
                <div class="text-center">
                    <a class="small" href="forgot-password.php">¿Olvidaste tu contraseña?</a>
                </div>

                <!-- Mensajes de éxito o error -->
                @if(session('message'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('message') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div> <!-- Cierre login-container -->

    <!-- JavaScript del header -->
    <script src="{{ asset('js/homepage.js') }}"></script>



    <!-- Falta los sistemas de inactividad del 'Dashboard_tarea' -->



    <script>
        // Funcionalidad del ojito para mostrar/ocultar contraseña
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        // 🔥 NUEVO: Auto-enfocar el campo de contraseña si el email ya está lleno
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.querySelector('input[name="email"]');
            const passwordInput = document.querySelector('input[name="password"]');
            
            if (emailInput && emailInput.value && passwordInput) {
                passwordInput.focus();
            }
            
            // Inicializar slider de fondo
            initLoginBgSlider();
        });

        // Slider de fondo para login
        function initLoginBgSlider() {
            const slides = document.querySelectorAll('.login-bg-slide');
            let currentSlide = 0;
            
            function nextSlide() {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add('active');
            }
            
            // Cambiar slide cada 6 segundos
            setInterval(nextSlide, 6000);
        }




        // 🔥 NUEVO: SweetAlert para logout exitoso con timer y progress bar
        @if(session('logout_exitoso'))
            Swal.fire({
                title: '¡Sesión Cerrada! 👋',
                html: `
                    <div style="text-align: center; padding: 0; margin: 0;">
                        <i class="fas fa-sign-out-alt" style="font-size: 50px; color: #28a745; margin-bottom: 10px;"></i>
                        <h3 style="color: #28a745; margin: 8px 0; font-size: 18px;">Sesión cerrada exitosamente</h3>
                        <p style="font-size: 14px; margin: 8px 0; color: #666;">Has cerrado sesión de forma segura.</p>
                        <hr style="margin: 10px 0; border-color: #e0e0e0;">
                        <p style="font-size: 13px; color: #666; margin: 8px 0;">
                            Este mensaje se cerrará automáticamente en <strong id="countdown">5</strong> segundos...
                        </p>
                        <div style="margin-top: 10px;">
                            <div style="background: #e9f7ef; padding: 8px; border-radius: 6px; border-left: 3px solid #28a745;">
                                <small style="color: #155724; font-size: 12px;">
                                    <i class="fas fa-shield-alt"></i> 
                                    Tu sesión ha sido cerrada de forma segura
                                </small>
                            </div>
                        </div>
                    </div>
                `,
                icon: 'success',
                showConfirmButton: false, // Sin botones, permitir clics fuera
                showCancelButton: false,  // Sin botones, permitir clics fuera
                allowOutsideClick: true, // Permitir clics fuera del popup
                allowEscapeKey: false, // No permitir escape
                background: '#e9f7ef',
                timer: 4000, // 4 segundos
                timerProgressBar: true, // Barra de progreso
                customClass: {
                    popup: 'logout-exitoso-popup',
                    title: 'logout-exitoso-title',
                    htmlContainer: 'logout-exitoso-content'
                },
                didOpen: () => {
                    // Contador regresivo
                    let countdown = 5; // 5 segundos
                    
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
                window.location.href = "{{ route('login') }}";

                // // Cuando el timer termine, enfocar el campo email
                // if (result.dismiss === Swal.DismissReason.timer) {
                //     const emailInput = document.querySelector('input[name="email"]');
                //     if (emailInput) {
                //         emailInput.focus();
                //     }
                // }
            });
        @endif
    </script>
</body>
</html>