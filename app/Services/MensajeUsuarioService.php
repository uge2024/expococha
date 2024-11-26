<?php


namespace App\Services;


use App\Repositories\MensajeUsuarioRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MensajeUsuarioService
{
    protected $mensajeUsuarioRepository;
    public function __construct(MensajeUsuarioRepository $mensajeUsuarioRepository)
    {
        $this->mensajeUsuarioRepository = $mensajeUsuarioRepository;
    }

    public function save($data)
    {
        return $this->mensajeUsuarioRepository->save($data);
    }

    public function getAllUsuariosQueMeMensajearon($usr_id_r)
    {
        return $this->mensajeUsuarioRepository->getAllUsuariosQueMeMensajearon($usr_id_r);
    }

    public function getAllMensajesConversacionByReceptorAndEmisor($usr_id_r,$usr_id_e)
    {
        $this->mensajeUsuarioRepository->actualizarAllVistoConversacionByReceptorAndEmisor($usr_id_r,$usr_id_e);
        return $this->mensajeUsuarioRepository->getAllMensajesConversacionByReceptorAndEmisor($usr_id_r,$usr_id_e);
    }

    public function getAllMensajesConversacionByReceptorAndEmisorAndUltimoMensaje($usr_id_r,$usr_id_e,$meu_id)
    {
        $this->mensajeUsuarioRepository->actualizarAllVistoConversacionByReceptorAndEmisor($usr_id_r,$usr_id_e);
        return $this->mensajeUsuarioRepository->getAllMensajesConversacionByReceptorAndEmisorAndUltimoMensaje($usr_id_r,$usr_id_e,$meu_id);
    }

    public function actualizarAllVistoConversacionByReceptorAndEmisor($usr_id_r,$usr_id_e)
    {
        DB::beginTransaction();
        $result = true;
        try {
            $this->mensajeUsuarioRepository->actualizarAllVistoConversacionByReceptorAndEmisor($usr_id_r,$usr_id_e);
            DB::commit();
        }catch (\Exception $e){
            $result = false;
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getEstadoVistoUltimoMensajeEnvie($usr_id_r,$usr_id_e)
    {
        return $this->mensajeUsuarioRepository->getEstadoVistoUltimoMensajeEnvie($usr_id_r,$usr_id_e);
    }

    public function countMensajesQueMeEnviaronSinLeer($usr_id_r)
    {
        return $this->mensajeUsuarioRepository->countMensajesQueMeEnviaronSinLeer($usr_id_r);
    }


}
