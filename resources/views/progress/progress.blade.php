@extends('layouts.app')

@section('title', 'Mi Progreso | Inversiones Pucara')

@section('content')
@php
$user = auth()->user();
$totalVideos = 0;
$completedVideos = 0;
$completedModules = 0;

foreach ($modules as $module) {
$module->total_videos = $module->videos->count();
$module->completed_videos = $module->videos->filter(fn($v) => $user->completedVideos->contains($v->id))->count();
$module->progress = $module->total_videos > 0 ? round(($module->completed_videos / $module->total_videos) * 100) : 0;

$totalVideos += $module->total_videos;
$completedVideos += $module->completed_videos;
if ($module->progress === 100) {
$completedModules++;
}

// Marcar los videos completados para vista
foreach ($module->videos as $video) {
$video->completed = $user->completedVideos->contains($video->id);
}
}

$totalModules = $modules->count();
$globalProgress = $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100) : 0;
@endphp
<style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2c3e50;
        --accent-color: #e74c3c;
        --light-color: #ecf0f1;
    }

    .progress-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 30px;
    }

    .progress-header {
        background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
        margin-bottom: 20px;
    }

    .global-progress {
        text-align: center;
        margin-bottom: 40px;
    }

    .progress-circle {
        width: 150px;
        height: 150px;
        margin: 0 auto 20px;
        position: relative;
    }

    .progress-circle svg {
        width: 100%;
        height: 100%;
    }

    .progress-circle circle {
        fill: none;
        stroke-width: 10;
        stroke-linecap: round;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }

    .progress-circle-bg {
        stroke: #f0f0f0;
    }

    .progress-circle-fill {
        stroke: #28a745;
        stroke-dasharray: 440;
        stroke-dashoffset: calc(440 - (440 * var(--progress)) / 100);
        transition: stroke-dashoffset 0.8s ease;
    }

    .progress-percentage {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2rem;
        font-weight: bold;
        color: var(--secondary-color);
    }

    .module-progress {
        margin-bottom: 30px;
    }

    .module-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 20px;
        border-left: 5px solid var(--primary-color);
        transition: all 0.3s ease;
    }

    .module-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .module-card.completed {
        border-left-color: #28a745;
        background-color: rgba(40, 167, 69, 0.05);
    }

    .progress-bar {
        height: 10px;
        border-radius: 5px;
        background-color: #e9ecef;
        margin: 15px 0;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 5px;
        background-color: #28a745;
        width: var(--progress);
        transition: width 0.6s ease;
    }

    .video-list {
        margin-top: 15px;
        padding-left: 20px;
    }

    .video-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 8px 12px;
        border-radius: 5px;
        transition: all 0.3s;
    }

    .video-item:hover {
        background-color: rgba(52, 152, 219, 0.1);
    }

    .video-item.completed {
        color: #28a745;
    }

    .video-item i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    .stat-card i {
        font-size: 2rem;
        color: var(--primary-color);
        margin-bottom: 10px;
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: bold;
        color: var(--secondary-color);
        margin-bottom: 5px;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .stats-container {
            grid-template-columns: 1fr;
        }

        .progress-circle {
            width: 120px;
            height: 120px;
        }

        .progress-percentage {
            font-size: 1.5rem;
        }
    }
</style>

<div class="progress-container animate__animated animate__fadeIn">
    <div class="progress-header">
        <h2><i class="fas fa-chart-line me-2"></i>Mi Progreso de Aprendizaje</h2>
        <p class="mb-0">Revisa tu avance en todos los módulos y videos</p>
    </div>

    <!-- Estadísticas globales -->
    <div class="global-progress">
        <div class="progress-circle">
            <svg viewBox="0 0 100 100">
                <circle class="progress-circle-bg" cx="50" cy="50" r="45"></circle>
                <circle class="progress-circle-fill" cx="50" cy="50" r="45"
                        style="--progress: {{ $globalProgress }}"></circle>
            </svg>
            <div class="progress-percentage">{{ $globalProgress }}%</div>
        </div>
        <h4>Progreso General</h4>
        <p class="text-muted">{{ $completedVideos }} de {{ $totalVideos }} videos completados</p>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="stats-container">
        <div class="stat-card">
            <i class="fas fa-book-open"></i>
            <div class="stat-number">{{ $totalModules }}</div>
            <div class="stat-label">Módulos Disponibles</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-check-circle"></i>
            <div class="stat-number">{{ $completedModules }}</div>
            <div class="stat-label">Módulos Completados</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-video"></i>
            <div class="stat-number">{{ $totalVideos }}</div>
            <div class="stat-label">Videos Totales</div>
        </div>
        <div class="stat-card">
            <i class="fas fa-check"></i>
            <div class="stat-number">{{ $completedVideos }}</div>
            <div class="stat-label">Videos Completados</div>
        </div>
    </div>

    <!-- Progreso por módulo -->
    <h4 class="mb-4"><i class="fas fa-layer-group me-2"></i>Progreso por Módulo</h4>

    @foreach($modules as $module)
    <div class="module-progress">
        <div class="module-card {{ $module->progress === 100 ? 'completed' : '' }}">
            <div class="d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-book me-2"></i>{{ $module->name }}</h5>
                <span class="badge bg-{{ $module->progress === 100 ? 'success' : 'primary' }}">
                    {{ $module->progress }}% completado
                </span>
            </div>

            <div class="progress-bar">
                <div class="progress-bar-fill" style="--progress: {{ $module->progress }}%"></div>
            </div>

            <div class="d-flex justify-content-between">
                <small class="text-muted">
                    {{ $module->completed_videos }} de {{ $module->total_videos }} videos
                </small>
                <small>
                    <a href="{{ route('modules.show', $module->id) }}" class="text-primary">
                        Ver módulo <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </small>
            </div>

            @if($module->videos->count() > 0)
            <div class="video-list">
                @foreach($module->videos as $video)
                <div class="video-item {{ $video->completed ? 'completed' : '' }}">
                    <i class="fas fa-video"></i>
                    <span>{{ $video->title }}</span>
                    @if($video->completed)
                    <i class="fas fa-check-circle ms-auto text-success"></i>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.module-card, .stat-card');
        elements.forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
@endsection
