@extends('layouts.AreaPublica.appPagepublic')

@section('title', 'EnglishLink - Aprende Inglés')
@section('description', 'Domina el inglés con nuestros cursos personalizados, profesores nativos y metodología innovadora. Tu futuro comienza aquí.')

@section('content')

    <!-- Hero Section with Modern Slider -->
    <section class="hero">
        <div class="hero-slider">
            <div class="slide active" style="background-image: url('{{ asset('img/Wow.jpg') }}')">
                <div class="slide-overlay"></div>
            </div>
            <div class="slide" style="background-image: url('{{ asset('img/Img2.jpg') }}')">
                <div class="slide-overlay"></div>
            </div>
            <div class="slide" style="background-image: url('{{ asset('img/Img3.jpg') }}')">
                <div class="slide-overlay"></div>
            </div>
            <div class="slide" style="background-image: url('{{ asset('img/Img4.jpg') }}')">
                <div class="slide-overlay"></div>
            </div>
            
            <!-- Navigation Arrows -->
            <div class="slider-nav">
                <button class="nav-btn prev-btn" id="prevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="nav-btn next-btn" id="nextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <!-- Dots Indicator -->
            <div class="slider-dots">
                <span class="dot active" data-slide="0"></span>
                <span class="dot" data-slide="1"></span>
                <span class="dot" data-slide="2"></span>
                <span class="dot" data-slide="3"></span>
            </div>
        </div>
        
        <div class="hero-content">
            <h1>Aprende Inglés con <span class="highlight">EnglishLink</span></h1>
            <p class="hero-description">
                Domina el inglés con nuestros cursos personalizados, profesores nativos y metodología innovadora. 
                Tu futuro comienza aquí.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('public.courses') }}" class="btn btn-primary">Ver Cursos</a>
                <a href="{{ route('public.contact') }}" class="btn btn-secondary">Contáctanos</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">¿Por qué elegir EnglishLink?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Profesores Nativos</h3>
                    <p>Aprende con profesores nativos certificados que te ayudarán a perfeccionar tu pronunciación.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Horarios Flexibles</h3>
                    <p>Estudia a tu ritmo con horarios flexibles que se adaptan a tu estilo de vida.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Certificaciones</h3>
                    <p>Obtén certificaciones reconocidas internacionalmente al completar nuestros cursos.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Clases Grupales</h3>
                    <p>Participa en clases grupales dinámicas y practica con otros estudiantes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Preview -->
    <section class="courses-preview">
        <div class="container">
            <h2 class="section-title">Nuestros Cursos</h2>
            <div class="courses-slider">
                <div class="course-card">
                    <img src="{{ asset('img/Img2.jpg') }}" alt="Curso Básico">
                    <div class="course-content">
                        <h3>Inglés Básico</h3>
                        <p>Ideal para principiantes que quieren empezar desde cero.</p>
                        <div class="course-meta">
                            <span class="level">Básico</span>
                            <span class="duration">3 meses</span>
                        </div>
                    </div>
                </div>
                <div class="course-card">
                    <img src="{{ asset('img/Img3.jpg') }}" alt="Curso Intermedio">
                    <div class="course-content">
                        <h3>Inglés Intermedio</h3>
                        <p>Perfecciona tu inglés y gana confianza al hablar.</p>
                        <div class="course-meta">
                            <span class="level">Intermedio</span>
                            <span class="duration">4 meses</span>
                        </div>
                    </div>
                </div>
                <div class="course-card">
                    <img src="{{ asset('img/Img4.jpg') }}" alt="Curso Avanzado">
                    <div class="course-content">
                        <h3>Inglés Avanzado</h3>
                        <p>Alcanza fluidez profesional en inglés.</p>
                        <div class="course-meta">
                            <span class="level">Avanzado</span>
                            <span class="duration">6 meses</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('public.courses') }}" class="btn btn-primary">Ver Todos los Cursos</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <h2 class="section-title">Lo que dicen nuestros estudiantes</h2>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>"EnglishLink cambió mi vida profesional. Los profesores son excelentes y la metodología muy efectiva."</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="{{ asset('img/Img5.jpg') }}" alt="María González">
                        <div>
                            <h4>María González</h4>
                            <span>Ingeniera de Software</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>"Gracias a EnglishLink pude conseguir el trabajo de mis sueños en una empresa internacional."</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="{{ asset('img/Img6.jpg') }}" alt="Carlos Rodríguez">
                        <div>
                            <h4>Carlos Rodríguez</h4>
                            <span>Marketing Manager</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>¿Listo para empezar tu viaje en inglés?</h2>
            <p>Únete a miles de estudiantes que han transformado sus vidas con EnglishLink</p>
            <a href="{{ route('public.contact') }}" class="btn btn-primary btn-large">Empezar Ahora</a>
        </div>
    </section>
@endsection
