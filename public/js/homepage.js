// Homepage JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    
    // Enhanced Mobile menu toggle
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    
    // Create overlay element
    const overlay = document.createElement('div');
    overlay.className = 'nav-overlay';
    document.body.appendChild(overlay);
    
    function toggleMenu() {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
        overlay.classList.toggle('active');
        document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
    }
    
    function closeMenu() {
        hamburger.classList.remove('active');
        navMenu.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    if (hamburger && navMenu) {
        // Toggle menu on hamburger click
        hamburger.addEventListener('click', toggleMenu);
        
        // Close menu on overlay click
        overlay.addEventListener('click', closeMenu);
        
        // Close menu on close button click (::before pseudo element)
        navMenu.addEventListener('click', function(e) {
            const rect = navMenu.getBoundingClientRect();
            const closeButtonArea = {
                x: rect.right - 60,
                y: rect.top,
                width: 60,
                height: 60
            };
            
            if (e.clientX >= closeButtonArea.x && e.clientX <= closeButtonArea.x + closeButtonArea.width &&
                e.clientY >= closeButtonArea.y && e.clientY <= closeButtonArea.y + closeButtonArea.height) {
                closeMenu();
            }
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', closeMenu);
        });
        
        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navMenu.classList.contains('active')) {
                closeMenu();
            }
        });
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Enhanced Header scroll effect with 180deg gradient
    const header = document.querySelector('.header');
    let lastScrollTop = 0;
    let ticking = false;

    function updateHeader() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Add scrolled class for enhanced background effect
        if (scrollTop > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        // Smart hide/show behavior
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scrolling down - hide header
            header.style.transform = 'translateY(-100%)';
        } else if (scrollTop < lastScrollTop || scrollTop <= 100) {
            // Scrolling up or near top - show header
            header.style.transform = 'translateY(0)';
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        ticking = false;
    }

    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateHeader);
            ticking = true;
        }
    });

    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe elements for animation
    const animateElements = document.querySelectorAll('.feature-card, .course-card, .testimonial-card');
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    // Course slider functionality (if needed for mobile)
    const coursesSlider = document.querySelector('.courses-slider');
    if (coursesSlider && window.innerWidth <= 768) {
        let isDown = false;
        let startX;
        let scrollLeft;

        coursesSlider.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX - coursesSlider.offsetLeft;
            scrollLeft = coursesSlider.scrollLeft;
        });

        coursesSlider.addEventListener('mouseleave', () => {
            isDown = false;
        });

        coursesSlider.addEventListener('mouseup', () => {
            isDown = false;
        });

        coursesSlider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - coursesSlider.offsetLeft;
            const walk = (x - startX) * 2;
            coursesSlider.scrollLeft = scrollLeft - walk;
        });
    }

    // Form validation (if contact forms are added later)
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Add loading animation for buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Add ripple effect
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Testimonials auto-rotate (optional)
    const testimonials = document.querySelectorAll('.testimonial-card');
    let currentTestimonial = 0;

    function rotateTestimonials() {
        if (testimonials.length > 1) {
            testimonials.forEach((testimonial, index) => {
                testimonial.style.opacity = index === currentTestimonial ? '1' : '0.5';
                testimonial.style.transform = index === currentTestimonial ? 'scale(1)' : 'scale(0.95)';
            });
            
            currentTestimonial = (currentTestimonial + 1) % testimonials.length;
        }
    }

    // Auto-rotate testimonials every 5 seconds
    if (testimonials.length > 1) {
        setInterval(rotateTestimonials, 5000);
    }

    // Add CSS for ripple effect
    const style = document.createElement('style');
    style.textContent = `
        .btn {
            position: relative;
            overflow: hidden;
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            pointer-events: none;
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // Console welcome message
    console.log('%c¡Bienvenido a EnglishLink!', 'color: #667eea; font-size: 20px; font-weight: bold;');
    console.log('%cSitio web desarrollado con Laravel + HTML5 + CSS3 + JavaScript', 'color: #764ba2; font-size: 14px;');

    // Add floating icons to hero sections
    addFloatingIcons();
});

// Add themed floating icons to hero sections
function addFloatingIcons() {
    const aboutHero = document.querySelector('.about-hero');
    const coursesHero = document.querySelector('.courses-hero');
    const contactHero = document.querySelector('.contact-hero');

    // About page icons (Education theme)
    if (aboutHero) {
        createFloatingIcon(aboutHero, '🎓', 'floating-icon-1', '25%', '12%', '2.5rem', 0.25, 'float 8s ease-in-out infinite');
        createFloatingIcon(aboutHero, '📖', 'floating-icon-2', 'auto', '15%', '3rem', 0.18, 'rotate360 12s linear infinite', '20%');
        createFloatingIcon(aboutHero, '✏️', 'floating-icon-3', '35%', 'auto', '2rem', 0.22, 'pulse 6s ease-in-out infinite', 'auto', '20%');
        createFloatingIcon(aboutHero, '🏆', 'floating-icon-4', '60%', '8%', '2.3rem', 0.2, 'bobbing 7s ease-in-out infinite');
    }

    // Courses page icons (Learning & Achievement theme)
    if (coursesHero) {
        createFloatingIcon(coursesHero, '📝', 'floating-icon-1', 'auto', 'auto', '2.8rem', 0.25, 'bobbing 5s ease-in-out infinite', '25%', '12%');
        createFloatingIcon(coursesHero, '🌟', 'floating-icon-2', '30%', 'auto', '2.2rem', 0.28, 'sparkle 3s ease-in-out infinite', 'auto', '25%');
        createFloatingIcon(coursesHero, '💡', 'floating-icon-3', 'auto', '18%', '2.5rem', 0.3, 'pulse 4s ease-in-out infinite', '15%');
        createFloatingIcon(coursesHero, '🚀', 'floating-icon-4', '40%', '25%', '2rem', 0.22, 'float 7s ease-in-out infinite');
        createFloatingIcon(coursesHero, '📊', 'floating-icon-5', '55%', 'auto', '2.1rem', 0.2, 'rotate360 15s linear infinite', 'auto', '30%');
    }

    // Contact page icons (Communication theme)
    if (contactHero) {
        createFloatingIcon(contactHero, '📞', 'floating-icon-1', '20%', '8%', '2.5rem', 0.28, 'bobbing 6s ease-in-out infinite');
        createFloatingIcon(contactHero, '✉️', 'floating-icon-2', '35%', 'auto', '2.2rem', 0.25, 'float 5s ease-in-out infinite', 'auto', '25%');
        createFloatingIcon(contactHero, '🤝', 'floating-icon-3', 'auto', '20%', '2.8rem', 0.24, 'pulse 4s ease-in-out infinite', '25%');
        createFloatingIcon(contactHero, '🌐', 'floating-icon-4', '25%', 'auto', '2rem', 0.32, 'rotate360 10s linear infinite', 'auto', '8%');
        createFloatingIcon(contactHero, '💼', 'floating-icon-5', '50%', '12%', '2.3rem', 0.2, 'float 8s ease-in-out infinite');
    }
}

function createFloatingIcon(container, emoji, className, top = 'auto', left = 'auto', fontSize = '2rem', opacity = 0.25, animation = 'float 6s ease-in-out infinite', bottom = 'auto', right = 'auto') {
    const icon = document.createElement('div');
    icon.className = className;
    icon.textContent = emoji;
    icon.style.cssText = `
        position: absolute;
        top: ${top};
        left: ${left};
        bottom: ${bottom};
        right: ${right};
        font-size: ${fontSize};
        opacity: ${opacity};
        animation: ${animation};
        pointer-events: none;
        z-index: 1;
        user-select: none;
    `;
    container.appendChild(icon);
}

// Utility functions
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction() {
        const context = this;
        const args = arguments;
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

// Optimize scroll events
const optimizedScroll = debounce(function() {
    // Any additional scroll optimizations can go here
}, 10);

window.addEventListener('scroll', optimizedScroll);

// ===== MODERN HERO SLIDER =====
const heroSlider = {
    init() {
        this.slides = document.querySelectorAll('.slide');
        this.dots = document.querySelectorAll('.dot');
        this.prevBtn = document.getElementById('prevBtn');
        this.nextBtn = document.getElementById('nextBtn');
        this.currentSlide = 0;
        this.slideInterval = null;
        
        if (!this.slides.length) return;
        
        this.bindEvents();
        this.startAutoSlide();
        this.preloadImages();
    },

    bindEvents() {
        // Next/Previous buttons
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => {
                this.nextSlide();
                this.resetAutoSlide();
            });
        }
        
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => {
                this.prevSlide();
                this.resetAutoSlide();
            });
        }

        // Dots navigation
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                this.goToSlide(index);
                this.resetAutoSlide();
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                this.prevSlide();
                this.resetAutoSlide();
            } else if (e.key === 'ArrowRight') {
                this.nextSlide();
                this.resetAutoSlide();
            }
        });

        // Pause on hover
        const slider = document.querySelector('.hero-slider');
        if (slider) {
            slider.addEventListener('mouseenter', () => this.pauseAutoSlide());
            slider.addEventListener('mouseleave', () => this.startAutoSlide());
        }

        // Touch/swipe support
        this.setupTouchEvents();
    },

    setupTouchEvents() {
        const slider = document.querySelector('.hero-slider');
        if (!slider) return;

        let startX = 0;
        let endX = 0;

        slider.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });

        slider.addEventListener('touchmove', (e) => {
            e.preventDefault();
        });

        slider.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            this.handleSwipe(startX, endX);
        });
    },

    handleSwipe(startX, endX) {
        const diff = startX - endX;
        const threshold = 50;

        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                this.nextSlide();
            } else {
                this.prevSlide();
            }
            this.resetAutoSlide();
        }
    },

    nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        this.updateSlider();
    },

    prevSlide() {
        this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        this.updateSlider();
    },

    goToSlide(index) {
        this.currentSlide = index;
        this.updateSlider();
    },

    updateSlider() {
        // Update slides
        this.slides.forEach((slide, index) => {
            slide.classList.toggle('active', index === this.currentSlide);
        });

        // Update dots
        this.dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === this.currentSlide);
        });
    },

    startAutoSlide() {
        this.slideInterval = setInterval(() => {
            this.nextSlide();
        }, 6000); // Change slide every 6 seconds
    },

    pauseAutoSlide() {
        if (this.slideInterval) {
            clearInterval(this.slideInterval);
            this.slideInterval = null;
        }
    },

    resetAutoSlide() {
        this.pauseAutoSlide();
        this.startAutoSlide();
    },

    preloadImages() {
        this.slides.forEach(slide => {
            const bgImage = slide.style.backgroundImage;
            if (bgImage) {
                const img = new Image();
                const url = bgImage.replace(/url\(['"]?(.*?)['"]?\)/, '$1');
                img.src = url;
            }
        });
    }
};

// Initialize slider when DOM is ready
heroSlider.init();
