@extends('layouts.AreaPublica.appPagepublic')

@section('title', 'Acerca de Nosotros - EnglishLink')
@section('description', 'Conoce la historia de EnglishLink, nuestra misión, visión y el equipo de profesores que hace posible tu aprendizaje del inglés.')

@section('content')

    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <h1>Acerca de EnglishLink</h1>
            <p class="hero-description">
                Más de 10 años transformando vidas a través del aprendizaje del inglés
            </p>
        </div>
    </section>

    <!-- About Content -->
    <section class="about-content">
        <div class="container">
            <div class="about-grid">
                <div>
                    <h2>Nuestra Historia</h2>
                    <p>
                        EnglishLink nació en 2014 con una visión clara: democratizar el aprendizaje del inglés en Colombia. 
                        Desde nuestros humildes comienzos con 5 estudiantes, hemos crecido hasta convertirmos en una de las 
                        academias de inglés más reconocidas del país.
                    </p>
                    <p>
                        Nuestra metodología única combina la enseñanza tradicional con tecnología moderna, creando una 
                        experiencia de aprendizaje inmersiva y efectiva.
                    </p>
                </div>
                <div>
                    <h2>Nuestra Misión</h2>
                    <p>
                        Empoderar a nuestros estudiantes con las habilidades en inglés necesarias para alcanzar sus metas 
                        personales y profesionales, proporcionando educación de alta calidad, personalizada e innovadora.
                    </p>
                    <h2>Nuestra Visión</h2>
                    <p>
                        Ser la academia líder en enseñanza del inglés en Latinoamérica, reconocida por nuestra excelencia 
                        académica, metodología innovadora y el éxito de nuestros estudiantes.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="services-section about-services">
        <div class="container">
            <h2>¿Por qué elegir EnglishLink?</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="service-card">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Profesores Expertos</h3>
                        <p>Aprende con hablantes nativos certificados y educadores experimentados apasionados por enseñar inglés.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <i class="fas fa-users"></i>
                        <h3>Grupos Pequeños</h3>
                        <p>Disfruta de atención personalizada en nuestras clases pequeñas, asegurando máxima práctica oral y retroalimentación individual.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <i class="fas fa-clock"></i>
                        <h3>Horarios Flexibles</h3>
                        <p>Elige entre clases matutinas, vespertinas o nocturnas que se adapten a tu estilo de vida ocupado.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <h2 class="section-title">Nuestros Logros</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>1,500+</h3>
                    <p>Estudiantes Graduados</p>
                </div>
                <div class="stat-item">
                    <h3>25+</h3>
                    <p>Profesores Certificados</p>
                </div>
                <div class="stat-item">
                    <h3>95%</h3>
                    <p>Tasa de Aprobación</p>
                </div>
                <div class="stat-item">
                    <h3>10+</h3>
                    <p>Años de Experiencia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="about-content">
        <div class="container">
            <h2 class="section-title">Nuestro Equipo</h2>
            <div class="about-grid">
                <div class="team-member">
                    <img src="{{ asset('img/teacher1.jpg') }}" alt="Sarah Johnson">
                    <h3>Sarah Johnson</h3>
                    <p><strong>Directora Académica</strong></p>
                    <p>Licenciada en Lingüística por Cambridge University. 15 años de experiencia en enseñanza del inglés.</p>
                </div>
                <div class="team-member">
                    <img src="{{ asset('img/teacher2.jpg') }}" alt="Michael Brown">
                    <h3>Michael Brown</h3>
                    <p><strong>Coordinador de Cursos</strong></p>
                    <p>Certificado TESOL y CELTA. Especialista en metodologías inmersivas de aprendizaje.</p>
                </div>
                <div class="team-member">
                    <img src="{{ asset('img/teacher3.jpg') }}" alt="Emma Wilson">
                    <h3>Emma Wilson</h3>
                    <p><strong>Profesora Senior</strong></p>
                    <p>Máster en Educación por Oxford University. Experta en preparación para exámenes internacionales.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">Nuestros Valores</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Pasión</h3>
                    <p>Amamos lo que hacemos y esa pasión se refleja en cada clase, cada interacción y cada resultado.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>Excelencia</h3>
                    <p>Nos comprometemos a brindar la más alta calidad en educación y servicio al estudiante.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3>Apoyo</h3>
                    <p>Creemos en acompañar a cada estudiante en su journey de aprendizaje, brindando apoyo constante.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3>Innovación</h3>
                    <p>Utilizamos las metodologías más avanzadas y tecnología moderna para optimizar el aprendizaje.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section about-cta">
        <div class="container">
            <h2>¿Listo para formar parte de nuestra familia?</h2>
            <p>Únete a los miles de estudiantes que han transformado sus vidas con EnglishLink</p>
            <a href="{{ route('public.contact') }}" class="cta-button">Contáctanos Hoy</a>
        </div>
    </section>
@endsection
