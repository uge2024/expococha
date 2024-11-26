<?php


namespace App\Utils;

use App\Notifications\VentaNotification;
use Illuminate\Support\Facades\Log;
use Notification;

class EnviarCorreosVentas
{
    public function __construct()
    {

    }

    public function enviarCorreosFerias($user,$asunto,$mensaje,$correos)
    {
        $res = true;
        try {
            Notification::send($user,new VentaNotification($asunto,$mensaje,$correos));
        }catch (\Exception $e){
            $res = false;
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
        return $res;
    }
}
