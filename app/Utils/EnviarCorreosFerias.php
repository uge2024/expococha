<?php


namespace App\Utils;


use App\Notifications\MensajeMasivoNotification;
use App\User;
use Illuminate\Support\Facades\Log;
use Notification;

class EnviarCorreosFerias
{
    /*private $asunto;
    private $mensaje;*/
    public function __construct()
    {

    }

    public function enviarCorreosFerias($user,$asunto,$mensaje,$correos)
    {
        $res = true;
        try {
            Notification::send($user,new MensajeMasivoNotification($asunto,$mensaje,$correos));
        }catch (\Exception $e){
            $res = false;
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
        return $res;
    }

}
