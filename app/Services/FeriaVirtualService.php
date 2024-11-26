<?php
namespace App\Services;

use App\Repositories\FeriaVirtualRepository;
use App\Repositories\ImagenFeriaVirtualRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class FeriaVirtualService
{
    protected $feriaVirtualRepository;
    protected $imagenFeriaVirtualRepository;
    public function __construct(FeriaVirtualRepository $feriaVirtualRepository,ImagenFeriaVirtualRepository $imagenFeriaVirtualRepository)
    {
        $this->feriaVirtualRepository = $feriaVirtualRepository;
        $this->imagenFeriaVirtualRepository = $imagenFeriaVirtualRepository;
    }

    public function getAll()
    {
        return $this->feriaVirtualRepository->getAll();
    }

    public function getAllPaginate($limit)
    {
        return $this->feriaVirtualRepository->getAllPaginate($limit);
    }

    public function save($data)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $feriaVirtual = $this->feriaVirtualRepository->save($data);
            $result = $this->imagenFeriaVirtualRepository->save($feriaVirtual,$data);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getById($fev_id)
    {
        $result = null;
        try {
            $result = $this->feriaVirtualRepository->getById($fev_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function update($data)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $feriaVirtual = $this->feriaVirtualRepository->update($data);
            $result = $this->imagenFeriaVirtualRepository->update($feriaVirtual,$data);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function delete($data,$texto)
    {
        $result = null;
        try {
            $result = $this->feriaVirtualRepository->delete($data,$texto);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getAllPaginateBySearchAndSortACAndEl($limit,$searchtype,$search,$sort)
    {
        return $this->feriaVirtualRepository->getAllPaginateBySearchAndSortACAndEl($limit,$searchtype,$search,$sort);
    }

    public function getferiasHabilitadas()
    {
        return $this->feriaVirtualRepository->getferiasHabilitadas();
    }

    public function getAllAcAndPaginateAndSort($limit,$sort)
    {
        return $this->feriaVirtualRepository->getAllAcAndPaginateAndSort($limit,$sort);
    }

    public function cargarferiasVirtualesComboHabilitado()
    {
        return $this->feriaVirtualRepository->cargarferiasVirtualesComboHabilitado();
    }

    public function getFeriasByLimitAndOrden($inicio,$limit,$orden)
    {
        return $this->feriaVirtualRepository->getFeriasByLimitAndOrden($inicio,$limit,$orden);
    }

    public function getProductosFeriasByFeriaAndLimitAndOrden($fev_id,$inicio,$limit,$orden)
    {
        return $this->feriaVirtualRepository->getProductosFeriasByFeriaAndLimitAndOrden($fev_id,$inicio,$limit,$orden);
    }

    public function getAllProductosFeriasAcAndTiendaAcByFeriaAndOrden($fev_id)
    {
        return $this->feriaVirtualRepository->getAllProductosFeriasAcAndTiendaAcByFeriaAndOrden($fev_id);
    }

}
