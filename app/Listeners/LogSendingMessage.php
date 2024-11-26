<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogSendingMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        //Log::info($event->message);
        $emailsArray = array_keys($event->message->getTo());
        $emails = implode(',',$emailsArray);
        $subject = $event->message->getSubject();
        Log::info('Se empieza a enviar correo a: '.$emails.' el motivo es: '.$subject);
    }
}
