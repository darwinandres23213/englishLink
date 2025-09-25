@extends('layouts.AreaPublica.appPagepublic')

@section('title', 'Nuestros Cursos - EnglishLink')
@section('description', 'Descubre nuestros cursos de inglés: básico, intermedio, avanzado, negocios y preparación para exámenes internacionales.')

@section('content')

    <!-- Hero Section -->
    <section class="courses-hero">
        <div class="container">
            <h1>Nuestros Cursos de Inglés</h1>
            <p class="hero-description">
                Descubre el curso perfecto para tu nivel y objetivos
            </p>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="about-content">
        <div class="container">
            <!-- Course Benefits Section -->
            <section class="services-section courses-services" style="padding: 60px 0; margin-bottom: 40px;">
                <div class="container">
                    <h2>Beneficios de Nuestros Cursos</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="service-card">
                                <i class="fas fa-rocket"></i>
                                <h3>Metodología Innovadora</h3>
                                <p>Combinamos técnicas tradicionales con tecnología moderna para un aprendizaje efectivo y dinámico.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="service-card">
                                <i class="fas fa-medal"></i>
                                <h3>Certificación Internacional</h3>
                                <p>Obtén certificados reconocidos mundialmente que abren puertas a nuevas oportunidades académicas y laborales.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="service-card">
                                <i class="fas fa-headset"></i>
                                <h3>Soporte 24/7</h3>
                                <p>Acceso continuo a recursos online, tutorías personalizadas y apoyo académico cuando lo necesites.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Curso Básico -->
            <div class="course-detail">
                <div class="course-header">
                    <span class="level-badge level-basic">Básico</span>
                    <h2>Inglés Básico</h2>
                    <p>Perfecto para principiantes que quieren empezar desde cero</p>
                </div>
                <div class="course-body">
                    <div class="course-features">
                        <div class="course-feature">
                            <i class="fas fa-clock"></i>
                            <span>3 meses de duración</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-users"></i>
                            <span>Máximo 8 estudiantes</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-calendar"></i>
                            <span>3 clases por semana</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-certificate"></i>
                            <span>Certificado incluido</span>
                        </div>
                    </div>
                    
                    <div class="curriculum">
                        <h4>¿Qué aprenderás?</h4>
                        <ul>
                            <li><i class="fas fa-check"></i> Fundamentos de gramática inglesa</li>
                            <li><i class="fas fa-check"></i> Vocabulario esencial (1000+ palabras)</li>
                            <li><i class="fas fa-check"></i> Conversaciones básicas cotidianas</li>
                            <li><i class="fas fa-check"></i> Pronunciación y fonética básica</li>
                            <li><i class="fas fa-check"></i> Presentaciones personales</li>
                            <li><i class="fas fa-check"></i> Expresiones de tiempo y lugar</li>
                        </ul>
                    </div>
                    
                    <div class="price-section">
                        <div class="price">$299.000 COP</div>
                        <p>Pago mensual disponible</p>
                        <a href="{{ route('public.contact') }}" class="btn btn-primary">Inscribirse Ahora</a>
                    </div>
                </div>
            </div>

            <!-- Curso Intermedio -->
            <div class="course-detail">
                <div class="course-header">
                    <span class="level-badge level-intermediate">Intermedio</span>
                    <h2>Inglés Intermedio</h2>
                    <p>Perfecciona tu inglés y gana confianza al comunicarte</p>
                </div>
                <div class="course-body">
                    <div class="course-features">
                        <div class="course-feature">
                            <i class="fas fa-clock"></i>
                            <span>4 meses de duración</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-users"></i>
                            <span>Máximo 6 estudiantes</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-calendar"></i>
                            <span>3 clases por semana</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-headphones"></i>
                            <span>Material multimedia</span>
                        </div>
                    </div>
                    
                    <div class="curriculum">
                        <h4>¿Qué aprenderás?</h4>
                        <ul>
                            <li><i class="fas fa-check"></i> Gramática intermedia (tiempos perfectos)</li>
                            <li><i class="fas fa-check"></i> Vocabulario ampliado (2500+ palabras)</li>
                            <li><i class="fas fa-check"></i> Conversaciones sobre temas variados</li>
                            <li><i class="fas fa-check"></i> Comprensión auditiva avanzada</li>
                            <li><i class="fas fa-check"></i> Escritura de textos cortos</li>
                            <li><i class="fas fa-check"></i> Presentaciones orales</li>
                        </ul>
                    </div>
                    
                    <div class="price-section">
                        <div class="price">$399.000 COP</div>
                        <p>Incluye material digital</p>
                        <a href="{{ route('public.contact') }}" class="btn btn-primary">Inscribirse Ahora</a>
                    </div>
                </div>
            </div>

            <!-- Curso Avanzado -->
            <div class="course-detail">
                <div class="course-header">
                    <span class="level-badge level-advanced">Avanzado</span>
                    <h2>Inglés Avanzado</h2>
                    <p>Alcanza fluidez profesional y domina el idioma</p>
                </div>
                <div class="course-body">
                    <div class="course-features">
                        <div class="course-feature">
                            <i class="fas fa-clock"></i>
                            <span>6 meses de duración</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-users"></i>
                            <span>Máximo 4 estudiantes</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-calendar"></i>
                            <span>4 clases por semana</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-briefcase"></i>
                            <span>Enfoque profesional</span>
                        </div>
                    </div>
                    
                    <div class="curriculum">
                        <h4>¿Qué aprenderás?</h4>
                        <ul>
                            <li><i class="fas fa-check"></i> Gramática avanzada completa</li>
                            <li><i class="fas fa-check"></i> Vocabulario especializado (5000+ palabras)</li>
                            <li><i class="fas fa-check"></i> Debates y discusiones complejas</li>
                            <li><i class="fas fa-check"></i> Inglés académico y profesional</li>
                            <li><i class="fas fa-check"></i> Redacción avanzada</li>
                            <li><i class="fas fa-check"></i> Presentaciones ejecutivas</li>
                        </ul>
                    </div>
                    
                    <div class="price-section">
                        <div class="price">$599.000 COP</div>
                        <p>Certificación internacional</p>
                        <a href="{{ route('public.contact') }}" class="btn btn-primary">Inscribirse Ahora</a>
                    </div>
                </div>
            </div>

            <!-- Inglés de Negocios -->
            <div class="course-detail">
                <div class="course-header">
                    <span class="level-badge level-business">Negocios</span>
                    <h2>Inglés de Negocios</h2>
                    <p>Especialízate en inglés corporativo y empresarial</p>
                </div>
                <div class="course-body">
                    <div class="course-features">
                        <div class="course-feature">
                            <i class="fas fa-clock"></i>
                            <span>3 meses de duración</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-users"></i>
                            <span>Máximo 6 estudiantes</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-laptop"></i>
                            <span>Modalidad híbrida</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-chart-line"></i>
                            <span>Casos reales de negocio</span>
                        </div>
                    </div>
                    
                    <div class="curriculum">
                        <h4>¿Qué aprenderás?</h4>
                        <ul>
                            <li><i class="fas fa-check"></i> Vocabulario empresarial especializado</li>
                            <li><i class="fas fa-check"></i> Comunicación en reuniones</li>
                            <li><i class="fas fa-check"></i> Presentaciones corporativas</li>
                            <li><i class="fas fa-check"></i> Negociación en inglés</li>
                            <li><i class="fas fa-check"></i> Emails y comunicación formal</li>
                            <li><i class="fas fa-check"></i> Networking profesional</li>
                        </ul>
                    </div>
                    
                    <div class="price-section">
                        <div class="price">$699.000 COP</div>
                        <p>Certificación BEC</p>
                        <a href="{{ route('public.contact') }}" class="btn btn-primary">Inscribirse Ahora</a>
                    </div>
                </div>
            </div>

            <!-- Preparación TOEFL/IELTS -->
            <div class="course-detail">
                <div class="course-header">
                    <span class="level-badge level-preparation">Preparación</span>
                    <h2>Preparación TOEFL/IELTS</h2>
                    <p>Prepárate para exámenes internacionales</p>
                </div>
                <div class="course-body">
                    <div class="course-features">
                        <div class="course-feature">
                            <i class="fas fa-clock"></i>
                            <span>8 semanas intensivas</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-users"></i>
                            <span>Máximo 4 estudiantes</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Simulacros de examen</span>
                        </div>
                        <div class="course-feature">
                            <i class="fas fa-trophy"></i>
                            <span>Garantía de puntaje</span>
                        </div>
                    </div>
                    
                    <div class="curriculum">
                        <h4>¿Qué aprenderás?</h4>
                        <ul>
                            <li><i class="fas fa-check"></i> Estrategias específicas para cada sección</li>
                            <li><i class="fas fa-check"></i> Técnicas de gestión del tiempo</li>
                            <li><i class="fas fa-check"></i> Práctica intensiva con exámenes reales</li>
                            <li><i class="fas fa-check"></i> Escritura académica avanzada</li>
                            <li><i class="fas fa-check"></i> Comprensión auditiva especializada</li>
                            <li><i class="fas fa-check"></i> Speaking con evaluación personalizada</li>
                        </ul>
                    </div>
                    
                    <div class="price-section">
                        <div class="price">$899.000 COP</div>
                        <p>Incluye 2 simulacros oficiales</p>
                        <a href="{{ route('public.contact') }}" class="btn btn-primary">Inscribirse Ahora</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">Beneficios de Estudiar con Nosotros</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Profesores Certificados</h3>
                    <p>Todos nuestros profesores son nativos o bilingües con certificaciones internacionales.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>Horarios Flexibles</h3>
                    <p>Clases matutinas, vespertinas y nocturnas. También ofrecemos clases los sábados.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3>Plataforma Digital</h3>
                    <p>Acceso 24/7 a nuestra plataforma con ejercicios, videos y material complementario.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3>Garantía de Calidad</h3>
                    <p>Si no estás satisfecho en las primeras 2 semanas, te devolvemos el 100% de tu dinero.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section courses-cta">
        <div class="container">
            <h2>¿No estás seguro cuál curso es para ti?</h2>
            <p>Agenda una evaluación gratuita y te ayudaremos a encontrar el curso perfecto</p>
            <a href="{{ route('public.contact') }}" class="cta-button">Evaluación Gratuita</a>
        </div>
    </section>
@endsection
