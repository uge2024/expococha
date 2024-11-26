<?php
namespace App\Services;
use App\Repositories\RubroRepository;
use Illuminate\Support\Facades\Log;

class RubroService
{
    protected $rubroRepository;
    public function __construct(RubroRepository $rubroRepository)
    {
        $this->rubroRepository = $rubroRepository;
    }

    public function getAll()
    {
        return $this->rubroRepository->getAll();
    }

    public function saveRubroData($data)
    {
        $result = null;
        try {
            $result = $this->rubroRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getById($rub_id)
    {
        $result = null;
        try {
            $result = $this->rubroRepository->getById($rub_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function update($data)
    {
        $result = null;
        try {
            $result = $this->rubroRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data,$texto)
    {
        $result = null;
        try {
            $result = $this->rubroRepository->delete($data,$texto);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getComboRubros(){
        return $this->rubroRepository->getComboRubros();
    }

    public function getAllPaginate($limit)
    {
        return $this->rubroRepository->getAllPaginate($limit);
    }

    public function getAllByAc()
    {
        return $this->rubroRepository->getAllByAc();
    }

}
