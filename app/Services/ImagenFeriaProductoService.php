<?php
namespace App\Services;
use App\Repositories\ImagenFeriaProductoRepository;
use Illuminate\Support\Facades\Log;

class ImagenFeriaProductoService
{
    protected $imagenFeriaProductoRepository;

    public function __construct( ImagenFeriaProductoRepository $imagenFeriaProductoRepository){
        $this->imagenFeriaProductoRepository = $imagenFeriaProductoRepository;
    }
    public function getById($ipf_id,$tipo)
    {
        $result = null;
        try {
            $result = $this->imagenFeriaProductoRepository->getListaImagenFeriaProductoByProducto($ipf_id,$tipo);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function getListaImagenFeriaProductoByProducto($fpr_id,$tipo)
    {
        $result = null;
        try {
            $result = $this->imagenFeriaProductoRepository->getListaImagenFeriaProductoByProducto($fpr_id,$tipo);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function getAllImagenesAcMatrizByFeriaProducto($fpr_id)
    {
        return $this->imagenFeriaProductoRepository->getAllImagenesAcMatrizByFeriaProducto($fpr_id);
    }
}
