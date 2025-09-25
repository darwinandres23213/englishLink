@extends('layouts.AreaPublica.appPagepublic')

@section('title', 'Contacto - EnglishLink')
@section('description', 'Contáctanos para más información sobre nuestros cursos de inglés. Agenda tu evaluación gratuita.')

@section('content')

    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <h1>Contáctanos</h1>
            <p class="hero-description">
                Estamos aquí para ayudarte a comenzar tu journey en inglés
            </p>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-content">
        <div class="container">
            <!-- Contact Services Section -->
            <section class="services-section contact-services" style="padding: 60px 0; margin-bottom: 40px;">
                <div class="container">
                    <h2>Múltiples Formas de Conectar</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="service-card">
                                <i class="fas fa-phone-alt"></i>
                                <h3>Llamada Inmediata</h3>
                                <p>Habla directamente con nuestros asesores educativos para resolver todas tus dudas al instante.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="service-card">
                                <i class="fas fa-video"></i>
                                <h3>Videollamada Gratis</h3>
                                <p>Agenda una consulta virtual personalizada para conocer mejor nuestros programas y metodología.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="service-card">
                                <i class="fas fa-map-marker-alt"></i>
                                <h3>Visítanos</h3>
                                <p>Conoce nuestras instalaciones, profesores y ambiente de aprendizaje en una visita guiada.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="contact-grid">
                <!-- Contact Form -->
                <div class="contact-form">
                    <h2>Envíanos un Mensaje</h2>
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="name">Nombre Completo *</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Correo Electrónico *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="course">Curso de Interés</label>
                            <select id="course" name="course">
                                <option value="">Selecciona un curso</option>
                                <option value="basico">Inglés Básico</option>
                                <option value="intermedio">Inglés Intermedio</option>
                                <option value="avanzado">Inglés Avanzado</option>
                                <option value="negocios">Inglés de Negocios</option>
                                <option value="preparacion">Preparación TOEFL/IELTS</option>
                                <option value="evaluacion">Evaluación Gratuita</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="level">Nivel Actual de Inglés</label>
                            <select id="level" name="level">
                                <option value="">Selecciona tu nivel</option>
                                <option value="principiante">Principiante</option>
                                <option value="basico">Básico</option>
                                <option value="intermedio">Intermedio</option>
                                <option value="avanzado">Avanzado</option>
                                <option value="no-se">No estoy seguro</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Mensaje *</label>
                            <textarea id="message" name="message" placeholder="Cuéntanos sobre tus objetivos, horarios preferidos, o cualquier pregunta que tengas..." required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            Enviar Mensaje
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="contact-info">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Nuestra Ubicación</h3>
                        <p>Calle 123 #45-67<br>Bogotá, Colombia<br>Zona Rosa</p>
                        <p><small>Cerca al Metro Estación Zona Rosa</small></p>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3>Teléfonos</h3>
                        <p><strong>Principal:</strong> +57 (1) 234-5678</p>
                        <p><strong>WhatsApp:</strong> +57 300 123 4567</p>
                        <p><strong>Emergencias:</strong> +57 310 987 6543</p>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Correos Electrónicos</h3>
                        <p><strong>General:</strong> info@englishlink.com</p>
                        <p><strong>Inscripciones:</strong> admisiones@englishlink.com</p>
                        <p><strong>Soporte:</strong> soporte@englishlink.com</p>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3>Redes Sociales</h3>
                        <div style="margin-top: 1rem;">
                            <a href="#" style="color: #667eea; margin-right: 1rem; font-size: 1.5rem;"><i class="fab fa-facebook"></i></a>
                            <a href="#" style="color: #667eea; margin-right: 1rem; font-size: 1.5rem;"><i class="fab fa-instagram"></i></a>
                            <a href="#" style="color: #667eea; margin-right: 1rem; font-size: 1.5rem;"><i class="fab fa-twitter"></i></a>
                            <a href="#" style="color: #667eea; margin-right: 1rem; font-size: 1.5rem;"><i class="fab fa-linkedin"></i></a>
                        </div>
                        <p style="margin-top: 1rem; font-size: 0.9rem;">Síguenos para tips de inglés diarios</p>
                    </div>
                </div>
            </div>

            <!-- Office Hours -->
            <div class="office-hours">
                <h3>Horarios de Atención</h3>
                <div class="hours-grid">
                    <div class="hours-item">
                        <strong>Lunes - Viernes</strong><br>
                        8:00 AM - 8:00 PM
                    </div>
                    <div class="hours-item">
                        <strong>Sábados</strong><br>
                        9:00 AM - 5:00 PM
                    </div>
                    <div class="hours-item">
                        <strong>Domingos</strong><br>
                        Cerrado
                    </div>
                    <div class="hours-item">
                        <strong>Festivos</strong><br>
                        Horario especial
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="map-section">
                <h2>Cómo Llegar</h2>
                <p>Estamos ubicados en el corazón de la Zona Rosa, con fácil acceso en transporte público</p>
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.8234892986144!2d-74.05870348573422!3d4.624335943649753!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f99a7f23f7b1d%3A0x4b8b8b8b8b8b8b8b!2sBogot%C3%A1%2C%20Colombia!5e0!3m2!1sen!2sco!4v1699999999999!5m2!1sen!2sco" 
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <h2 class="section-title">Preguntas Frecuentes</h2>
            
            <div class="faq-item">
                <button class="faq-question">
                    ¿Cuál es el proceso de inscripción?
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    El proceso es muy sencillo: 1) Agenda una evaluación gratuita, 2) Recibe recomendación de curso, 3) Realiza el pago, 4) ¡Comienza a estudiar! Todo el proceso toma máximo 2 días.
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-question">
                    ¿Ofrecen clases virtuales?
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Sí, ofrecemos modalidad presencial, virtual e híbrida. Puedes elegir la que mejor se adapte a tu estilo de vida y necesidades.
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-question">
                    ¿Qué pasa si no puedo asistir a una clase?
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Puedes reprogramar hasta 2 clases por mes sin costo adicional. También tendrás acceso a la grabación de la clase y material de apoyo.
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-question">
                    ¿Incluyen material de estudio?
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Sí, todos nuestros cursos incluyen material digital completo: libros, ejercicios interactivos, videos, audios y acceso a nuestra plataforma 24/7.
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-question">
                    ¿Ofrecen certificaciones?
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Al completar cualquier curso recibes un certificado de EnglishLink. Para cursos avanzados también puedes optar por certificaciones internacionales como Cambridge, TOEFL o IELTS.
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-question">
                    ¿Tienen descuentos disponibles?
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Sí, ofrecemos descuentos por pronto pago (10%), estudiantes (15%), y referidos (20%). También tenemos promociones especiales durante el año.
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section contact-cta">
        <div class="container">
            <h2>¡Agenda tu Evaluación Gratuita Hoy!</h2>
            <p>Descubre tu nivel actual y recibe una recomendación personalizada</p>
            <div style="margin-top: 2rem;">
                <a href="tel:+5712345678" class="cta-button" style="margin-right: 1rem; text-decoration: none;">
                    <i class="fas fa-phone"></i> Llamar Ahora
                </a>
                <a href="https://wa.me/573001234567" class="cta-button" target="_blank" style="text-decoration: none;">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </section>

@push('scripts')
<script>
        // FAQ Functionality
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const icon = question.querySelector('i');
                
                // Close all other FAQs
                document.querySelectorAll('.faq-answer').forEach(otherAnswer => {
                    if (otherAnswer !== answer) {
                        otherAnswer.classList.remove('active');
                        otherAnswer.previousElementSibling.querySelector('i').style.transform = 'rotate(0deg)';
                    }
                });
                
                // Toggle current FAQ
                answer.classList.toggle('active');
                icon.style.transform = answer.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
            });
        });

        // Contact Form Handling
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show success message (replace with actual form submission logic)
            alert('¡Gracias por tu mensaje! Nos pondremos en contacto contigo dentro de las próximas 24 horas.');
            
            // Reset form
            this.reset();
        });
    </script>
@endpush
@endsection
