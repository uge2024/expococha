<?php


namespace App\Services;


use App\Repositories\TipoPublicidadRepository;

class TipoPublicidadService
{

    protected $tipoPublicidadRepository;
    public function __construct(TipoPublicidadRepository $tipoPublicidadRepository)
    {
        $this->tipoPublicidadRepository = $tipoPublicidadRepository;
    }

    public function getAllCombo()
    {
        return $this->tipoPublicidadRepository->getAllCombo();
    }

    public function getTipoPublicidadByTipo($tpu_id)
    {
        return $this->tipoPublicidadRepository->getTipoPublicidadByTipo($tpu_id);
    }



}
