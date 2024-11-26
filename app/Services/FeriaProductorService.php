<?php


namespace App\Services;


use App\Repositories\FeriaProductorRepository;
use Illuminate\Support\Facades\Log;

class FeriaProductorService
{

    protected $feriaProductorRepository;
    public function __construct(FeriaProductorRepository $feriaProductorRepository)
    {
        $this->feriaProductorRepository = $feriaProductorRepository;
    }

    public function getAllPaginate($limit)
    {
        return $this->feriaProductorRepository->getAllPaginate($limit);
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->feriaProductorRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getById($fpd_id)
    {
        $result = null;
        try {
            $result = $this->feriaProductorRepository->getById($fpd_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function getFeriaProductorByferia($fev_id,$limit)
    {
        return $this->feriaProductorRepository->getFeriaProductorByferia($fev_id,$limit);
    }


    public function update($data)
    {
        $result = null;
        try {
            $result = $this->feriaProductorRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }


    public function delete($data,$texto)
    {
        $result = null;
        try {
            $result = $this->feriaProductorRepository->delete($data,$texto);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getFeriaVirtualOfferiaProductorComboByProductor($pro_id)
    {
        return $this->feriaProductorRepository->getFeriaVirtualOfferiaProductorComboByProductor($pro_id);
    }

    public function ExisteFeriaProductor($fev_id,$pro_id)
    {
        $result = $this->feriaProductorRepository->ExisteFeriaProductor($fev_id,$pro_id);
        return $result;
    }

    public function getFeriaProductorByProductor($pro_id,$limit)
    {
        $result = $this->feriaProductorRepository->getFeriaProductorByProductor($pro_id,$limit);
        return $result;
    }

    public function getFeriaProductorByProductorPaginateBySearchAndSort($limit,$pro_id,$searchtype,$search,$sort)
    {
        $result = $this->feriaProductorRepository->getFeriaProductorByProductorPaginateBySearchAndSort($limit,$pro_id,$searchtype,$search,$sort);
        return $result;
    }


}
