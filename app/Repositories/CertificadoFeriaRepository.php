<?php


namespace App\Repositories;


use App\Models\CertificadoFeria;

class CertificadoFeriaRepository
{
    protected $certificadoFeria;
    public function __construct(CertificadoFeria $certificadoFeria)
    {
        $this->certificadoFeria = $certificadoFeria;
    }

    public function save($data)
    {
        $dato = new $this->certificadoFeria();
        $dato->ip = $data['ip'];
        $dato->usuario = $data['usuario'];
        $dato->fecha = $data['fecha'];
        $dato->estado = $data['estado'];
        $dato->fondo = $data['fondo'];
        $dato->fev_id = $data['fev_id'];
        $dato->save();
        return $dato->fresh();
    }

    public function update($data)
    {
        $dato = $this->certificadoFeria->find($data['cef_id']);
        $dato->ip = $data['ip'];
        $dato->usuario = $data['usuario'];
        $dato->fecha = $data['fecha'];
        $dato->estado = $data['estado'];
        $dato->fondo = $data['fondo'];
        //$dato->fev_id = $data['fev_id'];
        $dato->save();
        return $dato->fresh();
    }

    public function getById($cef_id)
    {
        return $this->certificadoFeria->find($cef_id);
    }

    public function getByFeria($fev_id)
    {
        return $this->certificadoFeria->where([
            ['estado','=','AC'],
            ['fev_id','=',$fev_id]
        ])->first();
    }

}
