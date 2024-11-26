<?php


namespace App\Services;


use App\Repositories\CorreoEnviadoRepository;
use Illuminate\Support\Facades\Log;

class CorreoEnviadoService
{
    protected $correoEnviadoRepository;
    public function __construct(CorreoEnviadoRepository $correoEnviadoRepository)
    {
        $this->correoEnviadoRepository = $correoEnviadoRepository;
    }

    public function getAllpaginate($limit)
    {
        return $this->correoEnviadoRepository->getAllpaginate($limit);
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->correoEnviadoRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

}
