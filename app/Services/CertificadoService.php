<?php


namespace App\Services;


use App\Repositories\CertificadoRepository;
use Illuminate\Support\Facades\Log;

class CertificadoService
{

    protected $repository;
    public function __construct(CertificadoRepository $repository)
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

    public function getById($cer_id){
        return $this->repository->getById($cer_id);
    }

    public function getByProductorAndFeria($pro_id,$fev_id){
        return $this->repository->getByProductorAndFeria($pro_id,$fev_id);
    }

    public function getAllByFeria($fev_id){
        return $this->repository->getAllByFeria($fev_id);
    }


}
