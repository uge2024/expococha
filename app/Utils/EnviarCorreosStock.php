<?php


namespace App\Utils;

use App\Notifications\StockNotification;
use Illuminate\Support\Facades\Log;
use Notification;

class EnviarCorreosStock
{
    public function __construct()
    {

    }

    public function enviarCorreo($user,$asunto,$mensaje)
    {
        $res = true;
        try {
            Notification::send($user,new StockNotification($asunto,$mensaje));
        }catch (\Exception $e){
            $res = false;
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
        return $res;
    }
}
