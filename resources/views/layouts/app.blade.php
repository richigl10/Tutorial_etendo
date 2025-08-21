<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Inversiones Pucara')</title>

    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Estilos personalizados -->
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --admin-color: #8b5cf6;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 600;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            transform: translateY(-2px);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item:focus, .dropdown-item:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateX(5px);
        }

        main {
            min-height: calc(100vh - 120px);
        }

        footer {
            background: var(--secondary-color);
            color: white;
            padding: 15px 0;
            margin-top: 50px;
        }
    </style>

    @stack('styles')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-graduation-cap me-2"></i>Inversiones Pucara
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Left Side Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('home*') ? 'active-nav' : '' }}"
                           href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('modules*') ? 'active-nav' : '' }}"
                           href="{{ route('modules.index') }}">
                            <i class="fas fa-book me-1"></i> Módulos
                        </a>
                    </li>
                    <!-- Progreso en el menú superior -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('progress*') ? 'active-nav' : '' }}"
                           href="{{ route('progress.progress') }}">
                            <i class="fas fa-chart-line me-1"></i> Progreso
                        </a>
                    </li>

                    <!-- Panel de Admin - Solo visible para administradores -->
                    @auth
                    @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin*') ? 'active-nav' : '' }}"
                           href="{{ route('admin.index') }}">
                            <i class="fas fa-users-cog me-1"></i> Panel Admin
                        </a>
                    </li>
                    @endif
                    @endauth

                    <!-- Ayuda en el menú superior -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#helpModal">
                            <i class="fas fa-question-circle me-1"></i> Ayuda
                        </a>
                    </li>
                </ul>

                <!-- Right Side Navbar -->
                <ul class="navbar-nav ms-auto">
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                        </a>
                    </li>
                    @endif

                    <!-- ELIMINADO: El enlace público de registro ya no aparece aquí -->

                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('home') }}">
                                <i class="fas fa-home me-2"></i> Inicio
                            </a>
                            <!-- Enlace a Módulos -->
                            <a class="dropdown-item" href="{{ route('modules.index') }}">
                                <i class="fas fa-book me-2"></i> Módulos
                            </a>
                            <!-- Enlace a Progreso -->
                            <a class="dropdown-item" href="{{ route('progress.progress') }}">
                                <i class="fas fa-chart-line me-2"></i> Progreso
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- NUEVO: Enlace para cambiar contraseña -->
                            <a class="dropdown-item" href="{{ route('user.change-password') }}">
                                <i class="fas fa-key me-2"></i> Cambiar Contraseña
                            </a>

                            <!-- Panel de Admin en dropdown - Solo visible para administradores -->
                            @if(Auth::user()->role === 'admin')
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.index') }}">
                                <i class="fas fa-users-cog me-2"></i> Panel de Administración
                            </a>
                            <!-- NUEVO: Enlace para registrar usuarios -->
                            <a class="dropdown-item" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-2"></i> Registrar Usuario
                            </a>
                            <div class="dropdown-divider"></div>
                            @endif

                            <!-- Ayuda en el menú desplegable -->
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#helpModal">
                                <i class="fas fa-question-circle me-2"></i> Ayuda
                            </a>
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Inversiones Pucara. Todos los derechos reservados.</p>
        </div>
    </footer>
</div>

<!-- Modal de Ayuda -->
<div class="modal fade help-modal" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="helpModalLabel"><i class="fas fa-question-circle me-2"></i>Centro de Ayuda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Bienvenido al sistema de aprendizaje</h5>
                <p>Aquí encontrarás información útil para navegar por la plataforma:</p>

                <ul>
                    <li><strong>Módulos:</strong> Accede a todos los contenidos de aprendizaje organizados por módulos.</li>
                    <li><strong>Progreso:</strong> Revisa tu avance en los diferentes módulos y videos.</li>
                    <li><strong>Videos:</strong> Cada módulo contiene videos educativos que puedes marcar como completados.</li>
                    <li><strong>Barra lateral:</strong> Navega fácilmente entre los diferentes módulos y sus contenidos.</li>
                    <li><strong>Cambiar Contraseña:</strong> Puedes actualizar tu contraseña desde tu menú de usuario.</li>
                    @auth
                    @if(Auth::user()->role === 'admin')
                    <li><strong>Panel Admin:</strong> Como administrador, puedes acceder al panel de control para monitorear el progreso de todos los usuarios.</li>
                    <li><strong>Registrar Usuarios:</strong> Puedes crear nuevos usuarios y asignar roles desde tu menú de usuario.</li>
                    @endif
                    @endauth
                </ul>

                <p>Si necesitas asistencia adicional, por favor contacta a nuestro equipo de soporte:</p>
                <p><i class="fas fa-envelope me-2"></i> ricardo.lara@pucara.co.cu</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Scripts personalizados -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Activar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Efecto de scroll suave para anclas internas
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>

@stack('scripts')
</body>
</html>
