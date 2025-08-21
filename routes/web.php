<?php

use App\Http\Controllers\ProgressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController; // NUEVO: Importar UserController

// Rutas de autenticación
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// IMPORTANTE: Las rutas de registro ahora están protegidas y requieren ser admin
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Módulos
    Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/modules/{id}', [ModuleController::class, 'show'])->name('modules.show');

    // Videos
    Route::post('/videos/{id}/toggle-completed', [VideoController::class, 'toggleCompleted'])->name('videos.toggle-completed');
    Route::get('/videos/{video}/pdf', [VideoController::class, 'downloadPdf'])->name('videos.downloadPdf');

    // Progreso
    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.progress');

    // NUEVO: Rutas para gestión de usuario
    Route::get('/user/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.change-password');
    Route::put('/user/update-password', [UserController::class, 'updatePassword'])->name('user.update-password');
});

// Rutas de administración (requieren autenticación y rol admin)
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});
