<?php


namespace App\Repositories;

use App\Models\Productor;
use App\Models\Parametrica;

class ParametricaRepository
{
    protected $parametrica;
    public function __construct(Parametrica $parametrica)
    {
        $this->parametrica = $parametrica;
    }
    public function getParametricaByTipoAndCodigo($codigo):?Parametrica
    {
        return Parametrica::where('codigo','=',$codigo)->first();



    }


}
