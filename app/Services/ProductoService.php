<?php


namespace App\Services;


use App\Repositories\ImagenProductoRepository;
use App\Repositories\ProductoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductoService
{

    protected $productoRepository;
    protected $imagenProductoRepository;
    public function __construct(ProductoRepository $productoRepository, ImagenProductoRepository $imagenProductoRepository)
    {
        $this->productoRepository = $productoRepository;
        $this->imagenProductoRepository = $imagenProductoRepository;
    }

    public function getAllProductoByProductorPaginate($limit,$pro_id)
    {
        return $this->productoRepository->getAllProductoByProductorPaginate($limit,$pro_id);
    }


    public function getAllPaginateBySearchAndSortACAndEl($limit,$pro_id,$searchtype,$search,$sort)
    {
        return $this->productoRepository->getAllPaginateBySearchAndSortACAndEl($limit,$pro_id,$searchtype,$search,$sort);
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->productoRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }
    public function getById($prd_id)
    {
        $result = null;
        try {
            $result = $this->productoRepository->getById($prd_id);
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
            $producto = $this->productoRepository->update($data);
            $result = $this->imagenProductoRepository->update($producto,$data);
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
            $result = $this->productoRepository->delete($data,$texto);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function saveProductoAndImagenproducto($data)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $producto = $this->productoRepository->save($data);
            $result = $this->imagenProductoRepository->save($producto,$data);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getAllPaginateBySearchAndSort($limit,$searchtype,$search,$sort)
    {
        return $this->productoRepository->getAllPaginateBySearchAndSort($limit,$searchtype,$search,$sort);
    }

    public function getProductosRandomByLimit($limit,$dias)
    {
        return $this->productoRepository->getProductosRandomByLimit($limit,$dias);
    }

    public function getProductosEnOfertaRamdomByLimit($limit)
    {
        return $this->productoRepository->getProductosEnOfertaRamdomByLimit($limit);
    }

    public function getProductosNuevosRandomByLimitAndDiasNuevo($limit,$dias)
    {
        return $this->productoRepository->getProductosNuevosRandomByLimitAndDiasNuevo($limit,$dias);
    }

    public function getAllProductosBySortAndPaginate($sort,$limit)
    {
        return $this->productoRepository->getAllProductosBySortAndPaginate($sort,$limit);
    }

    public function getAllProductosOfertasBySortAndPaginate($sort,$limit)
    {
        return $this->productoRepository->getAllProductosOfertasBySortAndPaginate($sort,$limit);
    }

    public function getAllProductosNuevosBySortAndPaginate($sort,$limit,$dias)
    {
        return $this->productoRepository->getAllProductosNuevosBySortAndPaginate($sort,$limit,$dias);
    }

    public function getAllProductosByRubroSortAndPaginate($sort,$limit,$rub_id)
    {
        return $this->productoRepository->getAllProductosByRubroSortAndPaginate($sort,$limit,$rub_id);
    }

    public function getAllProductosByCategoriaSortAndPaginate($sort,$limit,$cat_id)
    {
        return $this->productoRepository->getAllProductosByCategoriaSortAndPaginate($sort,$limit,$cat_id);
    }

    public function getAllProductosBySearchAndSortAndPaginate($sort,$cat_id,$search,$limit)
    {
        return $this->productoRepository->getAllProductosBySearchAndSortAndPaginate($sort,$cat_id,$search,$limit);
    }

    public function agregarOferta($data)
    {
        DB::beginTransaction();
        $result = null;
        try {
            $result = $this->productoRepository->agregarOferta($data);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getAllProductosByProductorOrdenados($pro_id)
    {
        return $this->productoRepository->getAllProductosByProductorOrdenados($pro_id);
    }

    public function getAllProductosByProductorOrdenadosQueNoEstenEnUnaFeriaProductor($pro_id,$fpd_id)
    {
        return $this->productoRepository->getAllProductosByProductorOrdenadosQueNoEstenEnUnaFeriaProductor($pro_id,$fpd_id);
    }

    public function getAllProductosRelacionadosByCategoriaSortAndLimit($limit,$cat_id)
    {
        return $this->productoRepository->getAllProductosRelacionadosByCategoriaSortAndLimit($limit,$cat_id);
    }

    public function getProductosEnOfertaByInicioAndLimitAndOrden($inicio,$limit,$orden)
    {
        return $this->productoRepository->getProductosEnOfertaByInicioAndLimitAndOrden($inicio,$limit,$orden);
    }

    public function getProductosNuevosByInicioAndLimitAndDiasNuevoAndOrden($inicio,$limit,$orden,$dias)
    {
        return $this->productoRepository->getProductosNuevosByInicioAndLimitAndDiasNuevoAndOrden($inicio,$limit,$orden,$dias);
    }

    public function getProductosByInicioAndLimitAndOrden($inicio,$limit,$orden,$dias)
    {
        return $this->productoRepository->getProductosByInicioAndLimitAndOrden($inicio,$limit,$orden,$dias);
    }

    public function getProductosByCategoriaAndLimitAndOrden($cat_id,$inicio,$limit,$orden)
    {
        return $this->productoRepository->getProductosByCategoriaAndLimitAndOrden($cat_id,$inicio,$limit,$orden);
    }

    public function getProductosByRubroAndLimitAndOrden($rub_id,$inicio,$limit,$orden)
    {
        return $this->productoRepository->getProductosByRubroAndLimitAndOrden($rub_id,$inicio,$limit,$orden);
    }

    public function getProductosByBuscarAndLimitAndOrden($search,$inicio,$limit,$orden)
    {
        return $this->productoRepository->getProductosByBuscarAndLimitAndOrden($search,$inicio,$limit,$orden);
    }

}
