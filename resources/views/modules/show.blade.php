@extends('layouts.app')

@section('title', $currentModule->name . ' | Inversiones Pucara')

@section('content')
<style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2c3e50;
        --accent-color: #e74c3c;
        --light-color: #ecf0f1;
    }

    .hero-section {
        background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
        padding: 10px 0;
        position: relative;
        color: white;
        text-align: center;
    }

    .module-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .module-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .module-header {
        background: var(--secondary-color);
        color: white;
        padding: 20px;
    }

    .module-body {
        padding: 25px 25px 25px 10px;
    }

    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        background: #000;
        margin-bottom: 15px;
        margin-left: auto;
        width: 90%;
    }

    .video-container video {
        position: absolute;
        top: 0;
        left: 5%;
        width: 90%;
        height: 100%;
    }

    .sidebar-module {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 15px;
        margin-bottom: 20px;
    }

    .module-nav-item {
        padding: 8px 15px;
        border-left: 3px solid transparent;
        transition: all 0.3s;
        display: block;
        color: var(--secondary-color);
        text-decoration: none;
    }

    .module-nav-item:hover, .module-nav-item.active {
        border-left: 3px solid var(--primary-color);
        background: rgba(52, 152, 219, 0.1);
    }

    .main-container {
        max-width: 1200px;
        margin-left: 20px;
        margin-right: auto;
    }

    .sidebar-col {
        width: 300px;
        padding-right: 15px;
    }

    .content-col {
        width: calc(100% - 300px);
        padding-left: 15px;
    }

    @media (max-width: 992px) {
        .sidebar-col,
        .content-col {
            width: 100%;
            padding: 0;
        }

        .sidebar-module {
            margin-bottom: 30px;
        }

        .video-container {
            width: 100%;
            margin-left: 0;
        }

        .video-container video {
            left: 0;
            width: 100%;
        }
    }

    .video-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .video-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .video-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        opacity: 0;
        position: absolute;
    }

    .checkmark {
        display: inline-block;
        width: 18px;
        height: 18px;
        border: 2px solid #6c757d;
        border-radius: 4px;
        position: relative;
        transition: all 0.3s;
    }

    .video-checkbox input:checked ~ .checkmark {
        background-color: #28a745;
        border-color: #28a745;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        left: 5px;
        top: 1px;
        width: 4px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .video-checkbox input:checked ~ .checkmark:after {
        display: block;
    }

    .check-label {
        font-size: 14px;
        color: #6c757d;
        transition: color 0.3s;
    }

    .video-checkbox input:checked ~ .check-label {
        color: #28a745;
        font-weight: 500;
    }

    .video-completed {
        border-left: 4px solid #28a745;
        background-color: rgba(40, 167, 69, 0.05);
    }

    .module-accordion {
        border-radius: 8px;
    }

    .accordion-item {
        margin-bottom: 5px;
    }

    .accordion-header a {
        text-decoration: none;
    }

    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    .accordion-content.show {
        max-height: 1000px;
    }

    .accordion-icon {
        transition: transform 0.3s ease;
        font-size: 0.8rem;
        color: var(--secondary-color);
    }

    .accordion-content.show + .accordion-header .accordion-icon {
        transform: rotate(180deg);
    }

    .video-item {
        padding: 8px 15px 8px 35px;
        font-size: 0.9rem;
        position: relative;
        white-space: normal;
        word-break: break-word;
    }

    .video-item i.fa-video {
        position: absolute;
        left: 15px;
        top: 10px;
        font-size: 0.8rem;
        color: var(--primary-color);
    }

    .video-item.completed {
        color: #28a745;
    }

    .video-item.completed i.fa-video {
        color: #28a745;
    }

    .video-item.completed::after {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.8rem;
        color: #28a745;
    }

    .progress-container {
        margin-top: 20px;
        padding: 15px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .progress-title {
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--secondary-color);
        display: flex;
        align-items: center;
    }

    .progress-title i {
        margin-right: 10px;
        color: var(--primary-color);
    }

    .progress {
        height: 10px;
        border-radius: 5px;
        background-color: #e9ecef;
        margin-bottom: 10px;
    }

    .progress-bar {
        background-color: #28a745;
        transition: width 0.6s ease;
    }

    .progress-info {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .progress-percentage {
        font-weight: 600;
        color: var(--secondary-color);
    }

    /* Estilos simplificados para el PDF */
    .pdf-download-simple {
        margin-top: 15px;
    }

    .pdf-link {
        color: var(--accent-color);
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .pdf-link:hover {
        color: #c0392b;
        text-decoration: underline;
    }

    .pdf-link i {
        font-size: 1.1rem;
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-content">
        <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInDown">{{ $currentModule->name }}</h1>
        <p class="lead mb-5 animate__animated animate__fadeInUp animate__delay-1s">{{ $currentModule->description }}</p>
    </div>
</section>

<!-- Module Content -->
<section class="py-5">
    <div class="main-container">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="sidebar-col">
                <div class="sidebar-module animate__animated animate__fadeInLeft">
                    <h5 class="mb-3"><i class="fas fa-list-ul me-2"></i>Módulos</h5>
                    <nav class="nav flex-column module-accordion">
                        @foreach($allModules as $module)
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <a href="{{ route('modules.show', $module->id) }}"
                                   class="module-nav-item d-flex justify-content-between align-items-center {{ $module->id == $currentModule->id ? 'active' : '' }}">
                                    <span>
                                        <i class="fas fa-book me-2"></i>{{ $module->name }}
                                    </span>
                                    <i class="fas fa-chevron-down accordion-icon"></i>
                                </a>
                            </div>
                            <div class="accordion-content {{ $module->id == $currentModule->id ? 'show' : '' }}">
                                <div class="nav flex-column">
                                    @foreach($module->videos->sortBy('order') as $video)
                                    <a href="{{ route('modules.show', $module->id) }}#video-{{ $video->id }}"
                                       class="module-nav-item video-item {{ auth()->user()->completedVideos->contains($video->id) ? 'completed' : '' }}"
                                        <i class="fas fa-video"></i>
                                        {{ $video->title }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </nav>
                </div>

                <!-- Cuadro de Progreso -->
                <div class="progress-container animate__animated animate__fadeInLeft animate__delay-1s">
                    @php
                    $user = auth()->user();
                    $totalVideos = 0;
                    $completedVideos = 0;
                    foreach($allModules as $module) {
                    $totalVideos += $module->videos->count();
                    $completedVideos += $module->videos->filter(fn($v) => $user->completedVideos->contains($v->id))->count();
                    }
                    $progress = $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100) : 0;
                    @endphp
                    <div class="progress-title">
                        <i class="fas fa-chart-line"></i> Tu Progreso
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;"
                             aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="progress-info">
                        <span>{{ $completedVideos }} de {{ $totalVideos }} completados</span>
                        <span class="progress-percentage">{{ $progress }}%</span>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="content-col">
                @foreach($currentModule->videos->sortBy('order') as $video)
                <div class="module-card animate__animated animate__fadeIn {{ $video->completed ? 'video-completed' : '' }}"
                     id="video-{{ $video->id }}">
                    <div class="module-header">
                        <div class="video-status">
                            <h5><i class="fas fa-video me-2"></i>{{ $video->title }}</h5>
                            <label class="video-checkbox">
                                <input type="checkbox"
                                       class="video-completed-checkbox"
                                       data-video-id="{{ $video->id }}"
                                       {{ auth()->user()->completedVideos->contains($video->id) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <span class="check-label">
                                    {{ auth()->user()->completedVideos->contains($video->id) ? 'Completado' : 'Marcar como completado' }}
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="module-body">
                        <p>{{ $video->description }}</p>
                        <div class="video-container">
                            <video controls>
                                <source src="{{ asset('storage/' . $video->path) }}" type="video/mp4">
                                Tu navegador no soporta el elemento de video.
                            </video>
                        </div>

                        @if($video->pdf_path)
                        <div class="pdf-download-simple">
                            <a href="{{ route('videos.downloadPdf', $video->id) }}" class="pdf-link">
                                <i class="fas fa-file-pdf"></i> Descargar PDF
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Función para manejar los checkboxes de videos completados
        document.querySelectorAll('.video-completed-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', async function () {
                const videoId = this.dataset.videoId;
                const isCompleted = this.checked;
                const videoCard = document.getElementById(`video-${videoId}`);
                const checkLabel = this.nextElementSibling.nextElementSibling;

                try {
                    // Feedback visual inmediato
                    videoCard.classList.toggle('video-completed', isCompleted);
                    if (checkLabel) {
                        checkLabel.textContent = isCompleted ? 'Completado' : 'Marcar como completado';
                        checkLabel.style.color = isCompleted ? '#28a745' : '#6c757d';
                    }

                    const response = await fetch(`/videos/${videoId}/toggle-completed`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({completed: isCompleted})
                    });

                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }

                    const data = await response.json();

                    if (!data.success) {
                        throw new Error(data.message || 'Error al actualizar el estado');
                    }

                    // Actualizar el estado en la barra lateral
                    const videoItem = document.querySelector(`.video-item[href*="#video-${videoId}"]`);
                    if (videoItem) {
                        videoItem.classList.toggle('completed', isCompleted);
                    }

                    // Actualizar la barra de progreso
                    updateProgressBar();

                } catch (error) {
                    console.error('Error:', error);
                    // Revertir cambios visuales
                    this.checked = !isCompleted;
                    videoCard.classList.toggle('video-completed');
                    if (checkLabel) {
                        checkLabel.textContent = !isCompleted ? 'Completado' : 'Marcar como completado';
                        checkLabel.style.color = !isCompleted ? '#28a745' : '#6c757d';
                    }
                    alert('Error al guardar el estado: ' + error.message);
                }
            });
        });

        // Función para actualizar la barra de progreso
        function updateProgressBar() {
            const totalVideos = document.querySelectorAll('.video-item').length;
            const completedVideos = document.querySelectorAll('.video-item.completed').length;
            const progress = totalVideos > 0 ? Math.round((completedVideos / totalVideos) * 100) : 0;

            const progressBar = document.querySelector('.progress-bar');
            const progressInfo = document.querySelectorAll('.progress-info span');

            if (progressBar) {
                progressBar.style.width = `${progress}%`;
                progressBar.setAttribute('aria-valuenow', progress);
            }

            if (progressInfo && progressInfo.length >= 2) {
                progressInfo[0].textContent = `${completedVideos} de ${totalVideos} completados`;
                progressInfo[1].textContent = `${progress}%`;
            }
        }

        // Función para manejar el acordeón de módulos
        document.querySelectorAll('.accordion-header a').forEach(header => {
            header.addEventListener('click', function(e) {
                // Solo manejar clicks en el icono (evitar conflicto con navegación)
                if (e.target.classList.contains('accordion-icon') || e.target.parentElement.classList.contains('accordion-icon')) {
                    e.preventDefault();
                    const item = this.closest('.accordion-item');
                    const content = item.querySelector('.accordion-content');
                    const icon = item.querySelector('.accordion-icon');

                    content.classList.toggle('show');
                    icon.style.transform = content.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0)';
                }
            });
        });

        // Abrir automáticamente el módulo actual si está colapsado
        const currentModuleItem = document.querySelector('.accordion-item .module-nav-item.active').closest('.accordion-item');
        if (currentModuleItem) {
            const content = currentModuleItem.querySelector('.accordion-content');
            const icon = currentModuleItem.querySelector('.accordion-icon');
            content.classList.add('show');
            icon.style.transform = 'rotate(180deg)';
        }

        // Scroll suave al hacer clic en enlaces de video
        document.querySelectorAll('.video-item').forEach(item => {
            item.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href.includes('#')) {
                    e.preventDefault();
                    const targetId = href.split('#')[1];
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 20,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
