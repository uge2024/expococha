<?php
namespace App\Services;

use App\Repositories\ImagenFeriaVirtualRepository;
use Illuminate\Support\Facades\Log;

class ImagenFeriaVirtualService
{
    protected $imagenFeriaVirtualRepository;
    public function __construct( ImagenFeriaVirtualRepository $imagenFeriaVirtualRepository){
        $this->imagenFeriaVirtualRepository = $imagenFeriaVirtualRepository;
    }

    public function getById($ife_id,$tipo)
    {
        $result = null;
        try {
            $result = $this->imagenFeriaVirtualRepository->getById($ife_id,$tipo);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }
   public function getListaImagenFeriaVirtualByFeriaVirtual($fev_id,$tipo)
    {
        $result = null;
        try {
            $result = $this->imagenFeriaVirtualRepository->getListaImagenFeriaVirtualByFeriaVirtual($fev_id,$tipo);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }
}