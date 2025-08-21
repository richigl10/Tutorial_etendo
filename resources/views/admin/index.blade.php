@extends('layouts.app')

@section('title', 'Panel de Administración - Etendo ERP')

@push('styles')
<style>
    :root {
        /* Paleta de azules para todo el panel */
        --primary-color: #3498db;
        --secondary-color: #2c3e50;
        --accent-color: #2980b9;
        --light-blue: #5dade2;
        --dark-blue: #1b4f72;
        --admin-color: #3498db;

        /* Colores adicionales en tonos azules */
        --success-color: #3498db;
        --warning-color: #5dade2;
        --danger-color: #2980b9;
        --info-color: #85c1e9;
        --dark-color: #2c3e50;

        /* Sombras */
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .admin-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .admin-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
        animation: float 20s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .admin-title {
        font-size: 2.5rem;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        position: relative;
        z-index: 2;
    }

    .admin-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        position: relative;
        z-index: 2;
    }

    .stats-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow-xl);
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--light-blue));
    }

    .stats-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .filter-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
        border: none;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }

    .filter-card .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
        color: white;
        border-radius: 20px 20px 0 0 !important;
        padding: 1.5rem;
        font-weight: 600;
        font-size: 1.1rem;
        text-align: center;
        border: none;
    }

    .progress-table-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
        border: none;
        overflow: hidden;
    }

    .progress-table-card .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
        color: white;
        padding: 1.5rem;
        font-weight: 600;
        font-size: 1.2rem;
        text-align: center;
        border: none;
    }

    .form-select, .btn {
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
        border: none;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
        background: linear-gradient(135deg, var(--accent-color) 0%, var(--dark-blue) 100%);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--light-blue) 0%, var(--primary-color) 100%);
        border: none;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(93, 173, 226, 0.3);
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
    }

    .btn-outline-secondary {
        border: 2px solid var(--secondary-color);
        color: var(--secondary-color);
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background: var(--secondary-color);
        border-color: var(--secondary-color);
        transform: translateY(-2px);
    }

    .table {
        margin: 0;
    }

    .table thead th {
        background: linear-gradient(135deg, var(--secondary-color) 0%, #34495e 100%);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.05em;
        padding: 1.25rem 1rem;
        border: none;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border: none;
    }

    .table tbody tr:hover {
        background: rgba(52, 152, 219, 0.05);
        transform: scale(1.01);
    }

    .table tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border: none;
        border-bottom: 1px solid #f3f4f6;
    }

    .progress {
        height: 25px;
        border-radius: 50px;
        background: #f3f4f6;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(90deg, var(--light-blue) 0%, var(--primary-color) 100%);
        border-radius: 50px;
        position: relative;
        overflow: hidden;
        transition: all 0.8s ease;
    }

    .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background-image: linear-gradient(
            -45deg,
            rgba(255, 255, 255, .2) 25%,
            transparent 25%,
            transparent 50%,
            rgba(255, 255, 255, .2) 50%,
            rgba(255, 255, 255, .2) 75%,
            transparent 75%,
            transparent
        );
        background-size: 50px 50px;
        animation: move 2s linear infinite;
    }

    @keyframes move {
        0% { background-position: 0 0; }
        100% { background-position: 50px 50px; }
    }

    .progress-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: 600;
        font-size: 0.8rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        z-index: 2;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.875rem;
        text-align: center;
        display: inline-block;
        min-width: 120px;
    }

    .status-excellent {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
        color: white;
    }

    .status-good {
        background: linear-gradient(135deg, var(--light-blue) 0%, var(--primary-color) 100%);
        color: white;
    }

    .status-needs-improvement {
        background: linear-gradient(135deg, var(--accent-color) 0%, var(--dark-blue) 100%);
        color: white;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--light-blue) 100%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        margin-right: 12px;
    }

    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        color: var(--secondary-color);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
        color: var(--secondary-color);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-bottom: 1rem;
    }

    /* Colores específicos para los iconos de estadísticas */
    .bg-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%) !important;
    }

    .bg-success {
        background: linear-gradient(135deg, var(--light-blue) 0%, var(--primary-color) 100%) !important;
    }

    .bg-warning {
        background: linear-gradient(135deg, var(--info-color) 0%, var(--light-blue) 100%) !important;
    }

    .bg-info {
        background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 100%) !important;
    }

    /* Colores de texto */
    .text-primary {
        color: var(--primary-color) !important;
    }

    .text-success {
        color: var(--light-blue) !important;
    }

    .text-warning {
        color: var(--info-color) !important;
    }

    .text-info {
        color: var(--accent-color) !important;
    }

    /* Badges */
    .badge.bg-primary {
        background: var(--primary-color) !important;
    }

    .animate-counter {
        font-weight: 700;
        font-size: 2rem;
    }

    @media (max-width: 768px) {
        .admin-title {
            font-size: 2rem;
        }

        .table-responsive {
            font-size: 0.875rem;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            margin-right: 8px;
        }
    }
</style>
@endpush

@section('content')
<!-- Header de Administración -->
<div class="admin-header">
    <div class="container">
        <div class="text-center">
            <h1 class="admin-title mb-2">
                <i class="fas fa-chart-line me-3"></i>Panel de Administración
            </h1>
            <p class="admin-subtitle mb-0">
                Sistema de seguimiento de progreso - Etendo ERP Training
            </p>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Estadísticas generales -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card stats-card text-center p-4">
                <div class="stats-icon bg-primary mx-auto">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="animate-counter text-primary">{{ $allUsers->count() }}</h3>
                <p class="text-muted mb-0">Usuarios Registrados</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card text-center p-4">
                <div class="stats-icon bg-success mx-auto">
                    <i class="fas fa-play-circle"></i>
                </div>
                <h3 class="animate-counter text-success">{{ $totalVideos }}</h3>
                <p class="text-muted mb-0">Videos Disponibles</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card text-center p-4">
                <div class="stats-icon bg-warning mx-auto">
                    <i class="fas fa-book"></i>
                </div>
                <h3 class="animate-counter text-warning">{{ $modules->count() }}</h3>
                <p class="text-muted mb-0">Módulos Activos</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card text-center p-4">
                <div class="stats-icon bg-info mx-auto">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3 class="animate-counter text-info">
                    {{ $users->avg(function($user) use ($totalVideos) {
                    return $totalVideos > 0 ? round(($user->videos->count() / $totalVideos) * 100, 1) : 0;
                    }) }}%
                </h3>
                <p class="text-muted mb-0">Progreso Promedio</p>
            </div>
        </div>
    </div>

    <!-- Botón para registrar usuarios -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                <a href="{{ route('register') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Registrar Nuevo Usuario
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar de filtros -->
        <div class="col-lg-3">
            <div class="card filter-card">
                <div class="card-header">
                    <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
                </div>
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('admin.index') }}" class="d-flex flex-column gap-3">
                        <div>
                            <label for="user_id" class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>Usuario
                            </label>
                            <select name="user_id" id="user_id" class="form-select">
                                <option value="">Todos los usuarios</option>
                                @foreach($allUsers as $u)
                                <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="module_id" class="form-label fw-semibold">
                                <i class="fas fa-book me-2 text-success"></i>Módulo
                            </label>
                            <select name="module_id" id="module_id" class="form-select">
                                <option value="">Todos los módulos</option>
                                @foreach($modules as $m)
                                <option value="{{ $m->id }}" {{ request('module_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Aplicar Filtros
                            </button>
                            <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Limpiar Filtros
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabla de progreso -->
        <div class="col-lg-9">
            <div class="card progress-table-card">
                <div class="card-header">
                    <i class="fas fa-users-cog me-2"></i>Progreso de Usuarios
                    @if(request('user_id') || request('module_id'))
                    <small class="d-block mt-1 opacity-75">
                        Filtros activos:
                        @if(request('user_id'))
                        Usuario: {{ $allUsers->find(request('user_id'))->name ?? 'N/A' }}
                        @endif
                        @if(request('module_id'))
                        | Módulo: {{ $modules->find(request('module_id'))->name ?? 'N/A' }}
                        @endif
                    </small>
                    @endif
                </div>
                <div class="card-body p-0">
                    @if($users->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                            <tr>
                                <th><i class="fas fa-user me-2"></i>Usuario</th>
                                <th><i class="fas fa-envelope me-2"></i>Email</th>
                                <th><i class="fas fa-video me-2"></i>Videos</th>
                                <th><i class="fas fa-chart-line me-2"></i>Progreso</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            @php
                            $completedVideos = request('module_id')
                            ? $user->videos->where('module_id', request('module_id'))->count()
                            : $user->videos->count();

                            $progress = $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100, 1) : 0;

                            if ($progress >= 80) {
                            $statusClass = 'status-excellent';
                            $statusText = 'Excelente';
                            $statusIcon = 'fas fa-trophy';
                            } elseif ($progress >= 50) {
                            $statusClass = 'status-good';
                            $statusText = 'Bueno';
                            $statusIcon = 'fas fa-thumbs-up';
                            } else {
                            $statusClass = 'status-needs-improvement';
                            $statusText = 'Necesita Mejorar';
                            $statusIcon = 'fas fa-exclamation-triangle';
                            }
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted">{{ $user->email }}</td>
                                <td>
                                        <span class="badge bg-primary rounded-pill">
                                            {{ $completedVideos }}/{{ $totalVideos }}
                                        </span>
                                </td>
                                <td style="width: 250px;">
                                    <div class="progress position-relative">
                                        <div class="progress-bar"
                                             role="progressbar"
                                             style="width: {{ $progress }}%;"
                                             aria-valuenow="{{ $progress }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                        <span class="progress-text">{{ $progress }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-users-slash"></i>
                        <h4>No hay usuarios para mostrar</h4>
                        <p>No se encontraron usuarios que coincidan con los filtros aplicados.</p>
                        <a href="{{ route('admin.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-refresh me-2"></i>Mostrar todos los usuarios
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animación de contadores
        const counters = document.querySelectorAll('.animate-counter');
        counters.forEach(counter => {
            const target = parseInt(counter.innerText);
            let current = 0;
            const increment = target / 20;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                if (counter.innerText.includes('%')) {
                    counter.innerText = Math.floor(current) + '%';
                } else {
                    counter.innerText = Math.floor(current);
                }
            }, 50);
        });

        // Efectos hover para las filas de la tabla
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
            });
            row.addEventListener('mouseleave', function() {
                this.style.boxShadow = 'none';
            });
        });
    });
</script>
@endsection
