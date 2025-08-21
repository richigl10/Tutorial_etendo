@extends('layouts.app')

@section('title', 'Registrar Nuevo Usuario - Admin')

@push('styles')
<style>
    .admin-register-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
        overflow: hidden;
    }

    .admin-register-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #3498DBFF;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }

    .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        border-color: #3498DBFF;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }

    .btn-admin-primary {
        background: linear-gradient(135deg, #1b4f72 0%, #3498DBFF 100%);
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-admin-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px #1b4f72;
    }

    .btn-secondary {
        border: 2px solid #6b7280;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        background: #6b7280;
        border-color: #6b7280;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .admin-info-box {
        background: linear-gradient(135deg, #ddd6fe 0%, #e0e7ff 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .role-selector .form-check {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 10px;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .role-selector .form-check:hover {
        border-color: #3498DBFF;
    }

    .role-selector .form-check-input:checked ~ .form-check-label {
        color: #3498DBFF;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card admin-register-card">
                <div class="admin-register-header">
                    <h4 class="mb-2">
                        <i class="fas fa-user-plus me-2"></i>Registrar Nuevo Usuario
                    </h4>
                    <p class="mb-0 opacity-90">Panel de Administración - Etendo ERP</p>
                </div>

                <div class="card-body p-4">
                    <!-- Información para el administrador -->
                    <div class="admin-info-box">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            <strong>Información para Administradores</strong>
                        </div>
                        <small class="text-muted">
                            Como administrador, puedes crear nuevos usuarios y asignar roles. Los usuarios creados recibirán acceso inmediato a la plataforma.
                        </small>
                    </div>

                    <!-- Mostrar mensajes de éxito/error -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>Por favor corrige los errores a continuación.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-2 text-primary"></i>Nombre Completo
                            </label>
                            <input id="name"
                                   type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   autocomplete="name"
                                   autofocus
                                   placeholder="Ej: Juan Pérez">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2 text-success"></i>Correo Electrónico
                            </label>
                            <input id="email"
                                   type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   placeholder="ejemplo@pucara.co.cu">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Rol -->
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-user-tag me-2 text-warning"></i>Rol del Usuario
                            </label>
                            <div class="role-selector">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="role"
                                           id="roleUser"
                                           value="user"
                                           {{ old('role', 'user') == 'user' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="roleUser">
                                        <strong>Usuario Normal</strong>
                                        <br><small class="text-muted">Acceso a módulos y seguimiento de progreso</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="role"
                                           id="roleAdmin"
                                           value="admin"
                                           {{ old('role') == 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="roleAdmin">
                                        <strong>Administrador</strong>
                                        <br><small class="text-muted">Acceso completo + panel de administración</small>
                                    </label>
                                </div>
                            </div>

                            @error('role')
                            <div class="text-danger mt-1">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2 text-danger"></i>Contraseña
                            </label>
                            <input id="password"
                                   type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Mínimo 6 caracteres">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">
                                <i class="fas fa-lock me-2 text-danger"></i>Confirmar Contraseña
                            </label>
                            <input id="password-confirm"
                                   type="password"
                                   class="form-control"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Repetir la contraseña">
                        </div>

                        <!-- Botones -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-admin-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Crear Usuario
                            </button>
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver al Panel Admin
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>
@endsection
