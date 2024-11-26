<?php


namespace App\Services;
use App\Repositories\CategoriaRubroRepository;
use Illuminate\Support\Facades\Log;

class CategoriaRubroService
{

    protected $categoriaRubroRepository;
    public function __construct(CategoriaRubroRepository $categoriaRubroRepository)
    {
        $this->categoriaRubroRepository = $categoriaRubroRepository;
    }

    public function getAll()
    {
        return $this->categoriaRubroRepository->getAll();
    }

    public function saveCategoriaRuData($data)
    {
        $result = null;
        try {
            $result = $this->categoriaRubroRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }
    public function getById($cat_id)
    {
        $result = null;
        try {
            $result = $this->categoriaRubroRepository->getById($cat_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function update($data)
    {
        $result = null;
        try {
            $result = $this->categoriaRubroRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data,$texto)
    {
        $result = null;
        try {
            $result = $this->categoriaRubroRepository->delete($data,$texto);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getComboPadresCategoriaRubro(){
        return $this->categoriaRubroRepository->getComboPadresCategoriaRubro();
    }

    public function cargarComboCategoriasByRubro($rub_id){
        return $this->categoriaRubroRepository->cargarComboCategoriasByRubro($rub_id);
    }

    public function getListaCategoriasByRubro($rub_id){
        return $this->categoriaRubroRepository->getListaCategoriasByRubro($rub_id);
    }

    public function getAllPaginateCategoriasByRubro($limit,$rub_id)
    {
        return $this->categoriaRubroRepository->getAllPaginateCategoriasByRubro($limit,$rub_id);
    }

    public function cargarComboCategoriasByRubroHijos($rub_id){
        return $this->categoriaRubroRepository->cargarComboCategoriasByRubroHijos($rub_id);
    }

    public function getListaCategoriasACByRubro($rub_id)
    {
        return $this->categoriaRubroRepository->getListaCategoriasACByRubro($rub_id);
    }

}
