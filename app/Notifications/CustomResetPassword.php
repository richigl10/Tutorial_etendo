<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        \Log::info('Entrando a toMail() con email: ' . $notifiable->email);
        \Log::info('Email para reset:', ['email' => $notifiable->getEmailForPasswordReset()]);

        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Restablecer Contraseña')
            ->greeting('Hola ' . $notifiable->name)
            ->line('Recibiste este correo porque solicitaste un cambio de contraseña.')
            ->action('Restablecer Contraseña', $url)
            ->line('Si no solicitaste esto, puedes ignorar este mensaje.');
    }
}
