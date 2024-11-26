<?php
namespace App\Services;
use App\Repositories\AsociacionRepository;
use Illuminate\Support\Facades\Log;

class AsociacionService
{
    protected $asociacionRepository;
    public function __construct(AsociacionRepository $asociacionRepository)
    {
        $this->asociacionRepository = $asociacionRepository;
    }

    public function getAll()
    {
        return $this->asociacionRepository->getAll();
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->asociacionRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getById($aso_id)
    {
        $result = null;
        try {
            $result = $this->asociacionRepository->getById($aso_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function getAsociacionCombo()
    {
        return $this->asociacionRepository->getAsociacionCombo();
    }

    public function getAllPaginate($limit)
    {
        return $this->asociacionRepository->getAllPaginate($limit);
    }

    public function delete($data)
    {
        $result = null;
        try {
            $result = $this->asociacionRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }
    public function update($data)
    {
        $result = null;
        try {
            $result = $this->asociacionRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }
    public function getAllPaginateBySearchAndSort($limit,$searchtype,$search,$sort)
    {
        return $this->asociacionRepository->getAllPaginateBySearchAndSort($limit,$searchtype,$search,$sort);
    }


}
