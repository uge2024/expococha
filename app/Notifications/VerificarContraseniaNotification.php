<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificarContraseniaNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //$notifiable->email;
        $url = url(route('register.validateverification', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
        return (new MailMessage)
                    ->subject('Confirma tu correo electrónico')
                    ->line('Por favor pulsa el siguiente botón para confirmar tu correo electrónico.')
                    //->action('Confirmar mi correo', url('/validate'))
                    ->action('Confirmar mi correo', $url)
                    ->line('Este enlace para validar tu correo electrónico caduca en 60 minutos.')
                    ->line('¡Gracias por registrarse!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'token'=>$this->token,
            'email'=>$notifiable->email
        ];
    }
}
