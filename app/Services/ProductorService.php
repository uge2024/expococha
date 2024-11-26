<?php
namespace App\Services;

use App\Repositories\ProductorRepository;
use App\Repositories\ImagenProductorRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductorService
{
    protected $productorRepository;
    protected $imagenProductorRepository;

    public function __construct(ProductorRepository $productorRepository,
                                ImagenProductorRepository $imagenProductorRepository){
        $this->productorRepository = $productorRepository;
        $this->imagenProductorRepository = $imagenProductorRepository;
    }

    public function getAllPaginate($limit)
    {
        return $this->productorRepository->getAllPaginate($limit);
    }

    public function saveProductorAndImagenproductor($data)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $productor = $this->productorRepository->save($data);
            $result = $this->imagenProductorRepository->save($productor,$data);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getById($pro_id)
    {
        $result = null;
        try {
            $result = $this->productorRepository->getById($pro_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getProductorByProducto($prd_id)
    {
        $result = null;
        try {
            $result = $this->productorRepository->getProductorByProducto($prd_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function update($data)
    {
        $productor = null;
        try {
            $productor = $this->productorRepository->update($data);

            $result = $this->imagenProductorRepository->update($productor,$data);

        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $productor;
    }

    public function delete($data)
    {
        $result = null;
        try {
            $result = $this->productorRepository->delete($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getProductorByUser($usr_id)
    {
        $result = null;
        try {
            $result = $this->productorRepository->getProductorByUser($usr_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function getAllPaginateBySearchAndSort($limit,$searchtype,$search,$sort)
    {
        return $this->productorRepository->getAllPaginateBySearchAndSort($limit,$searchtype,$search,$sort);
    }

    public function updateEstadoTienda($pro_id,$estado_tienda)
    {
        $result = null;
        try {
            $result = $this->productorRepository->updateEstadoTienda($pro_id,$estado_tienda);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getByIdWithValoracionesAndImagenesAndProductos($pro_id)
    {
        return $this->productorRepository->getByIdWithValoracionesAndImagenesAndProductos($pro_id);
    }

    public function getProductoresByRubro($rub_id)
    {
        $result = null;
        try {
            $result = $this->productorRepository->getProductoresByRubro($rub_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getProductorComboByFeria($fev_id)
    {
        return $this->productorRepository->getProductorComboByFeria($fev_id);
    }

    public function getAllProductosAcByProductorAndSortAndLimit($pro_id,$inicio,$limit,$orden)
    {
        return $this->productorRepository->getAllProductosAcByProductorAndSortAndLimit($pro_id,$inicio,$limit,$orden);
    }

    public function getAllProductosAcByProductor($pro_id)
    {
        return $this->productorRepository->getAllProductosAcByProductor($pro_id);
    }

    public function getProductorComboByRubro($rub_id)
    {
        return $this->productorRepository->getProductorComboByRubro($rub_id);
    }

    public function getAllProductoresByFeriaVirtual($fev_id)
    {
        return $this->productorRepository->getAllProductoresByFeriaVirtual($fev_id);
    }
}
