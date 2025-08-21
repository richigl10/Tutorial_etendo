@extends('layouts.app')

@section('title', 'Panel de Control - Inversiones Pucara')

@section('content')
<style>
    .dashboard-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: calc(100vh - 120px);
        padding-top: 40px;
        padding-bottom: 60px;
    }

    .dashboard-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: white;
        position: relative;
    }

    .dashboard-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15);
    }

    .dashboard-header {
        background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
        color: white;
        padding: 25px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header h3 {
        position: relative;
        z-index: 2;
        font-weight: 600;
        margin: 0;
    }

    .dashboard-body {
        padding: 40px;
        position: relative;
    }

    .welcome-message {
        font-size: 1.2rem;
        color: #6c757d;
        margin-bottom: 30px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .status-badge {
        position: absolute;
        top: -15px;
        right: 30px;
        background-color: #28a745;
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: bold;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        z-index: 3;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        margin-top: 40px;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 25px 15px;
        border-radius: 10px;
        background: white;
        transition: all 0.3s ease;
        color: #2c3e50;
        text-decoration: none;
        border: 1px solid #e9ecef;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .action-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-color: #3498db;
    }

    .action-btn i {
        font-size: 2rem;
        margin-bottom: 15px;
        color: #3498db;
        transition: all 0.3s ease;
    }

    .action-btn:hover i {
        transform: scale(1.2);
        color: #2c3e50;
    }

    .action-btn span {
        font-weight: 600;
        font-size: 1rem;
    }

    .user-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: bold;
        box-shadow: 0 10px 20px rgba(44, 62, 80, 0.2);
        border: 4px solid white;
    }

    /* Efectos decorativos sutiles */
    .dashboard-header::after {
        content: '';
        position: absolute;
        bottom: -30px;
        right: -30px;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    /* Estilos para el modal de ayuda */
    .help-modal .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .help-modal .modal-header {
        background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        border: none;
    }

    .help-modal .modal-body {
        padding: 30px;
        line-height: 1.8;
    }

    .help-modal .modal-body h5 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .help-modal .modal-body ul {
        padding-left: 20px;
    }

    .help-modal .modal-body li {
        margin-bottom: 10px;
    }

    .help-modal .btn-close {
        filter: invert(1);
    }
</style>

<div class="dashboard-container">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="dashboard-card animate__animated animate__fadeIn">
                    <div class="dashboard-header">
                        <h3><i class="fas fa-tachometer-alt me-2"></i>Panel de Control</h3>
                    </div>

                    <div class="dashboard-body">
                        @if (session('status'))
                        <div class="status-badge animate__animated animate__bounceIn">
                            <i class="fas fa-check-circle me-1"></i> {{ session('status') }}
                        </div>
                        @endif

                        <div class="text-center mb-4">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <h4 class="fw-bold mb-3">¡Bienvenido, {{ Auth::user()->name }}!</h4>
                            <p class="welcome-message">Aquí puedes gestionar tu experiencia de aprendizaje y acceder a todos los recursos disponibles</p>
                        </div>

                        <div class="quick-actions">
                            <a href="{{ route('modules.index') }}" class="action-btn animate__animated animate__fadeInUp">
                                <i class="fas fa-book-open"></i>
                                <span>Módulos</span>
                            </a>
                            <a href="{{ route('progress.progress') }}" class="action-btn animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                                <i class="fas fa-chart-line"></i>
                                <span>Progreso</span>
                            </a>
                            @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.index') }}" class="action-btn animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                                <i class="fas fa-users-cog me-2"></i>
                                <span>Panel de Administración</span>
                            </a>
                            @endif
                            <a href="#" class="action-btn animate__animated animate__fadeInUp" style="animation-delay: 0.3s" data-bs-toggle="modal" data-bs-target="#helpModal">
                                <i class="fas fa-question-circle"></i>
                                <span>Ayuda</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animación escalonada para los botones
        const actionBtns = document.querySelectorAll('.action-btn');
        actionBtns.forEach((btn, index) => {
            btn.style.animationDelay = `${index * 0.1}s`;
        });

        // Opcional: Mostrar automáticamente el modal si es la primera visita
    @if(!session()->has('help_shown'))
        // Descomenta la siguiente línea si quieres que se muestre automáticamente
        // new bootstrap.Modal(document.getElementById('helpModal')).show();
    @php session()->put('help_shown', true); @endphp
    @endif
    });
</script>
@endsection
