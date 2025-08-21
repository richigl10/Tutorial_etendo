@extends('layouts.app')

@section('title', 'Inicio - Inversiones Pucara')

@section('content')
<style>
    .hero-section {
        padding: 40px 0;
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        position: relative;
        overflow: hidden;
        color: white;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-hero-primary {
        background-color: #e74c3c;
        border-color: #e74c3c;
        color: white;
        transition: all 0.3s ease;
        min-width: 180px;
    }

    .btn-hero-primary:hover {
        background-color: #c0392b;
        border-color: #c0392b;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .btn-hero-outline {
        border: 2px solid white;
        color: white;
        background-color: transparent;
        transition: all 0.3s ease;
        min-width: 180px;
    }

    .btn-hero-outline:hover {
        background-color: rgba(255,255,255,0.1);
        transform: translateY(-3px);
    }

    .features-section {
        padding: 160px 0;
        background-color: #f8f9fa;
    }

    .feature-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        border-radius: 50%;
        font-size: 2rem;
    }

    .cta-section {
        padding: 20px 0;
        background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .cta-btn {
        padding: 12px 30px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .contact-info-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
        border: 2px solid #dee2e6;
    }

    .admin-contact-badge {
        background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1rem;
    }
</style>

<div class="welcome-container">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-content">
            <div class="row justify-content-center">
                <div class="col-lg-14 text-center">
                    <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">Bienvenido a <span class="text-warning">Inversiones Pucara</span></h1>
                    <p class="lead mb-5 animate__animated animate__fadeInUp animate__delay-1s">Plataforma de aprendizaje ETENDO</p>

                    <div class="hero-buttons animate__animated animate__fadeInUp animate__delay-1s">
                        @guest
                        <a href="{{ route('login') }}" class="btn btn-hero-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
                        </a>
                        <!-- ELIMINADO: Botón de registro público -->
                        @else
                        <a href="{{ route('modules.index') }}" class="btn btn-hero-primary btn-lg">
                            <i class="fas fa-book-open me-2"></i> Ir a Módulos
                        </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-3">¿Por qué elegir nuestra plataforma?</h2>
                    <p class="lead text-muted">Aprende a tu ritmo con nuestros módulos interactivos</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                    <div class="feature-card p-4 text-center">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-video"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Videos Instructivos</h4>
                        <p>Contenido multimedia de alta calidad para un aprendizaje efectivo y entretenido.</p>
                    </div>
                </div>

                <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                    <div class="feature-card p-4 text-center">
                        <div class="feature-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Seguimiento de Progreso</h4>
                        <p>Visualiza tu avance y mantén la motivación con nuestro sistema de seguimiento.</p>
                    </div>
                </div>

                <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
                    <div class="feature-card p-4 text-center">
                        <div class="feature-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Domina Etendo</h4>
                        <p>Lleva tus conocimientos al siguiente nivel para poder desarrollar todas tus tareas con soltura.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @guest
    <!-- Información de contacto para acceso -->
    <section class="contact-info-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-info-box text-center">
                        <div class="admin-contact-badge">
                            <i class="fas fa-shield-alt me-2"></i>Acceso Restringido
                        </div>
                        <h4 class="mb-3">¿Necesitas una cuenta?</h4>
                        <p class="mb-3 text-muted">
                            El registro en esta plataforma está restringido por seguridad.
                            Para obtener acceso, contacta con nuestro equipo de administración.
                        </p>
                        <div class="d-flex justify-content-center gap-4 flex-wrap">
                            <div class="contact-method">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <strong>Email:</strong>
                                <a href="mailto:ricardo.lara@pucara.co.cu">ricardo.lara@pucara.co.cu</a>
                            </div>
                        </div>
                        <p class="mt-3 small text-muted">
                            Los administradores pueden crear cuentas desde su panel de control.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endguest

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            @guest
            <h2 class="fw-bold mb-4">¿Ya tienes una cuenta?</h2>
            <p class="lead mb-5">Accede a tu plataforma de aprendizaje</p>
            <a href="{{ route('login') }}" class="btn btn-light cta-btn">
                <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
            </a>
            @else
            <h2 class="fw-bold mb-4">¿Listo para continuar?</h2>
            <p class="lead mb-5">Sigue con tu aprendizaje donde lo dejaste</p>
            <a href="{{ route('modules.index') }}" class="btn btn-outline-light cta-btn">
                <i class="fas fa-arrow-right me-2"></i> Continuar Aprendizaje
            </a>
            @endguest
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animación para las tarjetas de características
        const featureCards = document.querySelectorAll('.feature-card');
        featureCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });

        // Efecto de scroll para animaciones
        const animateOnScroll = function() {
            const elements = document.querySelectorAll('.animate__animated');
            elements.forEach((element) => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;

                if(elementPosition < screenPosition) {
                    element.style.visibility = 'visible';
                    element.classList.add(element.getAttribute('data-animation'));
                }
            });
        };

        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll(); // Ejecutar al cargar
    });
</script>
@endsection
