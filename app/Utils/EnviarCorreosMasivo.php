<?php


namespace App\Utils;

use App\Notifications\MensajeMasivoPromocionNotification;
use App\User;
use Illuminate\Support\Facades\Log;
use Notification;

class EnviarCorreosMasivo
{
    public function __construct()
    {

    }

    public function enviarCorreosMasivo($user,$asunto,$mensaje,$correos)
    {
        $res = true;
        try {
            Notification::send($user,new MensajeMasivoPromocionNotification($asunto,$mensaje,$correos));
        }catch (\Exception $e){
            $res = false;
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
        return $res;
    }
}
