<?php
namespace App\Services;

use App\Repositories\ImagenProductoRepository;
use Illuminate\Support\Facades\Log;

class ImagenProductoService
{

    protected $imagenProductoRepository;

    public function __construct( ImagenProductoRepository $imagenProductoRepository){
        $this->imagenProductoRepository = $imagenProductoRepository;
    }
    public function getById($ipd_id,$tipo)
    {
        $result = null;
        try {
            $result = $this->imagenProductoRepository->getById($ipd_id,$tipo);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }
    public function getListaImagenProductoByProducto($prd_id,$tipo)
    {
        $result = null;
        try {
            $result = $this->imagenProductoRepository->getListaImagenProductoByProducto($prd_id,$tipo);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function getAllImagenesAcMatrizByProducto($prd_id)
    {
        return $this->imagenProductoRepository->getAllImagenesAcMatrizByProducto($prd_id);
    }

}
