<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;


/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;
    protected $connection = 'mysql';
    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role',
        'remember_token'
    ];

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Verificar si el usuario es un usuario normal
     */
    public function isUser()
    {
        return $this->role === 'user' || $this->role === null;
    }

    public function sendPasswordResetNotification($token)
    {
        $to = $this->email;
        $url = url(route('password.reset', ['token' => $token, 'email' => $to], false));
        \Log::info('Enviando reset manual a: ' . $to);

        Mail::raw("Enlace para resetear tu contraseña: $url", function ($message) use ($to) {
            $message->to($to)->subject('Recupera tu contraseña');
        });
    }

    public function completedVideos()
    {
        return $this->belongsToMany(Video::class, 'user_video')->withTimestamps();
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'user_video')->withTimestamps();
    }
}
