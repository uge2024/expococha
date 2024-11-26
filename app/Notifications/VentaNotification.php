<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VentaNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $asunto;
    private $mensaje;
    private $correos;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($asunto,$mensaje,$correos)
    {
        $this->asunto = $asunto;
        $this->mensaje = $mensaje;
        $this->correos = $correos;
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
        if(count($this->correos) > 0){
            return (new MailMessage)
                ->bcc($this->correos)
                ->subject($this->asunto)
                ->line($this->mensaje);
        }else{
            return (new MailMessage)
                ->subject($this->asunto)
                ->line($this->mensaje);
        }
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
            'token'=>$this->mensaje,
            'email'=>$notifiable->email
        ];
    }
}
