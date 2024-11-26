<?php


namespace App\Services;


use App\Repositories\BackupRepository;
use Illuminate\Support\Facades\Log;

class BackupService
{
    protected $repository;
    public function __construct(BackupRepository $repository)
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

}
