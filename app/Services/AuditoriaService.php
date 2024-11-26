<?php


namespace App\Services;


use App\Repositories\AuditoriaRepository;
use Illuminate\Support\Facades\Log;

class AuditoriaService
{
    protected $repository;
    public function __construct(AuditoriaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->repository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getTodosPaginateBySearchAndSort($limit,$searchtype,$search,$sort,$fecha_inicio,$fecha_fin)
    {
        return $this->repository->getTodosPaginateBySearchAndSort($limit,$searchtype,$search,$sort,$fecha_inicio,$fecha_fin);
    }

    public function getTodosBySearchAndSort($searchtype,$search,$sort,$fecha_inicio,$fecha_fin)
    {
        return $this->repository->getTodosBySearchAndSort($searchtype,$search,$sort,$fecha_inicio,$fecha_fin);
    }

}
