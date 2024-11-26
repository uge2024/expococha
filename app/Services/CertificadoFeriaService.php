<?php


namespace App\Services;


use App\Repositories\CertificadoFeriaRepository;
use Illuminate\Support\Facades\Log;

class CertificadoFeriaService
{
    protected $repository;
    public function __construct(CertificadoFeriaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save($data){
        $result = null;
        try {
            $result = $this->repository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function update($data){
        $result = null;
        try {
            $result = $this->repository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getById($cef_id){
        return $this->repository->getById($cef_id);
    }

    public function getByFeria($fev_id){
        return $this->repository->getByFeria($fev_id);
    }
}
