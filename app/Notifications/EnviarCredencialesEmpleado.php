<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EnviarCredencialesEmpleado extends Notification
{
    protected $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('👋 Bienvenido a Caficrédito')
            ->greeting('Hola ' . $notifiable->nombre .'')
            ->line('Tu cuenta ha sido creada exitosamente. Aquí están tus credenciales de acceso:')
            ->line(new \Illuminate\Support\HtmlString(
                '<div style="background-color:#f8f4f2;border-left:5px solid #c27c6b;padding:15px;margin:10px 0;font-family:sans-serif;">
                    <p><strong>Correo:</strong> ' . $notifiable->email . '</p>
                    <p><strong>Contraseña:</strong> ' . $this->password . '</p>
                </div>'
            ))
            ->line('Puedes iniciar sesión y cambiar tu contraseña cuando lo desees.')
            ->action('Iniciar sesión', url('/'))
            ->line('Gracias por formar parte de Caficrédito.')
            ->salutation(new \Illuminate\Support\HtmlString(
                '<p style="color:#a94442;margin-top:20px;">— El equipo de Caficrédito</p>'
            ));
    }    
}
