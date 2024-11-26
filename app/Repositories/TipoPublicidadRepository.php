<?php


namespace App\Repositories;


use App\Models\Rubro;
use App\Models\TipoPublicidad;

class TipoPublicidadRepository
{
    protected $tipoPublicidad;
    public function __construct(TipoPublicidad $tipoPublicidad)
    {
        $this->tipoPublicidad = $tipoPublicidad;
    }

    public function getAllCombo()
    {
        $listacombo = $this->tipoPublicidad->where([
        ])->orderBy('tipo','asc')->pluck("nombre",'tpu_id','listacombo')->prepend('Seleccione un tipo','0');

        return $listacombo;
    }
/*
    public function getTipoPublicidadByTipo($tpu_id)
    {
        $tipoPublicidad = TipoPublicidad::where([
            ['tpu_id','=',$tpu_id]
        ])->get();
        return $tipoPublicidad;
    }
*/
    public function getTipoPublicidadByTipo($tpu_id)
    {
        $tipoPublicidad = TipoPublicidad::find($tpu_id);
        return $tipoPublicidad;

    }


}
