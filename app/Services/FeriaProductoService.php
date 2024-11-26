<?php
namespace App\Services;

use App\Repositories\ImagenFeriaProductoRepository;
use App\Repositories\FeriaProductoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FeriaProductoService
{
    protected $feriaProductoRepository;
    protected $imagenFeriaProductoRepository;
    public function __construct(FeriaProductoRepository $feriaProductoRepository, ImagenFeriaProductoRepository $imagenFeriaProductoRepository)
    {
        $this->feriaProductoRepository = $feriaProductoRepository;
        $this->imagenFeriaProductoRepository = $imagenFeriaProductoRepository;
    }

    public function getFeriaProductoByferiaProductor($fpd_id,$limit)
    {
        return $this->feriaProductoRepository->getFeriaProductoByferiaProductor($fpd_id,$limit);
    }

    public function saveFeriaProductoAndImagenFeriaproducto($data)
    {
        DB::beginTransaction();
        $feriaProducto = null;
        try {
            $feriaProducto = $this->feriaProductoRepository->save($data);
            $result = $this->imagenFeriaProductoRepository->save($feriaProducto,$data);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $feriaProducto;
    }

    public function getById($fpr_id)
    {
        $result = null;
        try {
            $result = $this->feriaProductoRepository->getById($fpr_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function update($data)
    {
        DB::beginTransaction();
        $feriaProducto = null;
        try {
            $feriaProducto = $this->feriaProductoRepository->update($data);
            $result = $this->imagenFeriaProductoRepository->update($feriaProducto,$data);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $feriaProducto;
    }

    public function delete($data,$texto)
    {
        $result = null;
        try {
            $result = $this->feriaProductoRepository->delete($data,$texto);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getAllPaginateBySearchAndSortACAndEl($limit,$fpd_id,$searchtype,$search,$sort)
    {
        return $this->feriaProductoRepository->getAllPaginateBySearchAndSortACAndEl($limit,$fpd_id,$searchtype,$search,$sort);
    }




 }
