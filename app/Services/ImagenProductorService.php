<?php
namespace App\Services;

use App\Repositories\ImagenProductorRepository;
use Illuminate\Support\Facades\Log;

class ImagenProductorService
{
    protected $imagenProductorRepository;
    public function __construct( ImagenProductorRepository $imagenProductorRepository){
        $this->imagenProductorRepository = $imagenProductorRepository;
    }

    public function getByIdImagenIcono($ipd_id)
    {
        $result = null;
        try {
            $result = $this->imagenProductorRepository->getByIdImagenIcono($ipd_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function getById($ipd_id,$tipo)
    {
        $result = null;
        try {
            $result = $this->imagenProductorRepository->getById($ipd_id,$tipo);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }
    public function getListaImagenProductorByProductor($pro_id,$tipo)
    {
        $result = null;
        try {
            $result = $this->imagenProductorRepository->getListaImagenProductorByProductor($pro_id,$tipo);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }
}
