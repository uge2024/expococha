<?php


namespace App\Services;

use App\Models\Parametrica;
use App\Repositories\ParametricaRepository;

class ParametricaService
{
    protected $parametricaRepository;
    public function __construct(ParametricaRepository $parametricaRepository)
    {
        $this->parametricaRepository = $parametricaRepository;
    }
    public function getParametricaByTipoAndCodigo($codigo){
        return $this->parametricaRepository->getParametricaByTipoAndCodigo($codigo);
    }

}
