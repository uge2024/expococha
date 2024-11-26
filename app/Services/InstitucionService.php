<?php

namespace App\Services;
use App\Repositories\InstitucionRepository;
use Illuminate\Support\Facades\Log;

class InstitucionService
{
    protected $institucionRepository;
    public function __construct(InstitucionRepository $institucionRepository)
    {
        $this->institucionRepository = $institucionRepository;
    }

    public function getAll()
    {
        return $this->institucionRepository->getAll();
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->institucionRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getById($ins_id)
    {
        $result = null;
        try {
            $result = $this->institucionRepository->getById($ins_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function update($data)
    {
        $result = null;
        try {
            $result = $this->institucionRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }
}
