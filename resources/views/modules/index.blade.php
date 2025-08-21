@extends('layouts.app')

@section('title', 'Plataforma de Aprendizaje | Inversiones Pucara')

@section('content')
@php
$user = auth()->user();
@endphp
<style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2c3e50;
        --accent-color: #e74c3c;
        --light-color: #ecf0f1;
    }

    .hero-section {
        background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
        padding: 60px 0 40px;
        position: relative;
        color: white;
        text-align: center;
        margin-bottom: 40px;
    }

    .main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
    }

    .sidebar-col {
        width: 280px;
        padding-right: 30px;
        position: sticky;
        top: 20px;
        align-self: flex-start;
    }

    .content-col {
        flex: 1;
    }

    .module-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 30px;
        position: relative;
        height: 100%; /* Asegura que todas las tarjetas ocupen el 100% del contenedor */
        display: flex;
        flex-direction: column;
    }

    .module-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .module-header {
        background: var(--secondary-color);
        color: white;
        padding: 20px;
    }

    .module-body {
        padding: 25px;
        flex: 1; /* Hace que el cuerpo ocupe el espacio restante */
        display: flex;
        flex-direction: column;
    }

    .module-description {
        flex-grow: 1; /* Hace que la descripción ocupe el espacio disponible */
        margin-bottom: 15px;
    }

    .btn-module {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
        margin-top: auto; /* Empuja el botón hacia abajo */
    }

    .btn-module:hover {
        background: var(--accent-color);
        transform: scale(1.05);
    }

    .progress {
        height: 8px;
        background-color: #e9ecef;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .progress-bar {
        background-color: #28a745;
    }

    .progress-text {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
        color: #6c757d;
    }

    .module-completed {
        border-left: 4px solid #28a745;
    }

    .module-completed-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: #28a745;
        color: white;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    /* Estilos para el cuadro de progreso */
    .progress-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 25px;
    }

    .progress-title {
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--secondary-color);
        display: flex;
        align-items: center;
    }

    .progress-title i {
        margin-right: 10px;
        color: var(--primary-color);
    }

    .progress-info {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
    }

    .progress-percentage {
        font-weight: 600;
        color: var(--secondary-color);
    }

    .modules-header {
        margin-bottom: 30px;
        padding-left: 60px;
    }

    /* Estilos para igualar altura de módulos */
    .modules-row {
        display: flex;
        flex-wrap: wrap;
    }

    .module-col {
        display: flex; /* Hace que las columnas sean flexibles */
        margin-bottom: 30px;
    }

    @media (max-width: 992px) {
        .main-container {
            flex-direction: column;
        }

        .sidebar-col {
            width: 100%;
            padding-right: 0;
            margin-bottom: 30px;
            position: relative;
        }

        .content-col {
            width: 100%;
        }

        .modules-header {
            padding-left: 15px;
        }

        .module-col {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    @media (min-width: 992px) {
        .module-col {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 0 15px;
        }
    }

    /* Estilos para truncar texto largo */
    .module-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 3em; /* Altura mínima para dos líneas */
    }

    .module-desc {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 4.5em; /* Altura mínima para tres líneas */
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInDown">Tutoriales ETENDO</h1>
        <p class="lead mb-0 animate__animated animate__fadeInUp animate__delay-1s">Accede a nuestros módulos de formación en ETENDO</p>
    </div>
</section>

<!-- Main Content -->
<section class="py-3">
    <div class="main-container">
        <!-- Sidebar con progreso -->
        <div class="sidebar-col animate__animated animate__fadeInLeft">
            <div class="progress-container">
                @php
                $totalVideos = 0;
                $completedVideos = 0;

                foreach($modules as $module) {
                $totalVideos += $module->videos->count();
                $completedVideos += $module->videos->filter(function ($video) use ($user) {
                return $user->completedVideos->contains($video->id);
                })->count();
                }

                $globalProgress = $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100) : 0;
                @endphp
                <div class="progress-title">
                    <i class="fas fa-chart-line"></i> Tu Progreso
                </div>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ $globalProgress }}%;"
                         aria-valuenow="{{ $globalProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress-info">
                    <span>{{ $completedVideos }} de {{ $totalVideos }} videos</span>
                    <span class="progress-percentage">{{ $globalProgress }}%</span>
                </div>
            </div>

            <div class="progress-container">
                <div class="progress-title">
                    <i class="fas fa-book"></i> Tus Módulos
                </div>
                <div class="list-group">
                    @foreach($modules as $module)
                    @php
                    $total = $module->videos->count();
                    $completed = $module->videos->filter(fn($v) => $user->completedVideos->contains($v->id))->count();
                    $progress = $total > 0 ? round(($completed / $total) * 100) : 0;
                    @endphp
                    <a href="{{ route('modules.show', $module->id) }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $progress === 100 ? 'list-group-item-success' : '' }}">
                        {{ $module->name }}
                        <span class="badge bg-primary rounded-pill">{{ $progress }}%</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="content-col">
            <div class="modules-header">
                <h2 class="fw-bold">Nuestros Módulos de Formación</h2>
                <p class="lead text-muted">Selecciona el módulo que deseas explorar</p>
            </div>

            <div class="modules-row">
                @foreach($modules as $module)
                @php
                $total = $module->videos->count();
                $completed = $module->videos->filter(fn($v) => $user->completedVideos->contains($v->id))->count();
                $progress = $total > 0 ? round(($completed / $total) * 100) : 0;
                @endphp
                <div class="module-col animate__animated animate__fadeInUp">
                    <div class="module-card {{ $progress === 100 ? 'module-completed' : '' }}">
                        @if($progress === 100)
                        <span class="module-completed-badge animate__animated animate__bounceIn">
                                <i class="fas fa-check-circle me-1"></i> Completado
                            </span>
                        @endif
                        <div class="module-header">
                            <h3 class="module-title"><i class="fas fa-book-open me-2"></i>{{ $module->name }}</h3>
                        </div>
                        <div class="module-body">
                            <p class="module-desc">{{ $module->description }}</p>

                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $progress }}%"></div>
                            </div>

                            <div class="progress-text">
                                <span>Progreso: {{ $progress }}%</span>
                                <span>{{ $completed }} / {{ $total }} videos</span>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('modules.show', $module->id) }}" class="btn btn-module">
                                    Acceder <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.module-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
@endsection
