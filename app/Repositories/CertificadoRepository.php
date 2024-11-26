<?php


namespace App\Repositories;


use App\Models\Certificado;

class CertificadoRepository
{
    protected $certificado;
    public function __construct(Certificado $certificado)
    {
        $this->certificado = $certificado;
    }

    public function save($data)
    {
        $dato = new $this->certificado();
        $dato->ip = $data['ip'];
        $dato->usuario = $data['usuario'];
        $dato->fecha = $data['fecha'];
        $dato->codigo = $data['codigo'];
        $dato->nombre = $data['nombre'];
        $dato->feria = $data['feria'];
        $dato->version = $data['version'];
        $dato->fecha_inicio = $data['fecha_inicio'];
        $dato->fecha_final = $data['fecha_final'];
        $dato->estado = $data['estado'];
        $dato->pro_id = $data['pro_id'];
        $dato->fev_id = $data['fev_id'];
        $dato->save();
        return $dato->fresh();
    }

    public function update($data)
    {
        $dato = $this->certificado->find($data['cer_id']);
        $dato->ip = $data['ip'];
        $dato->usuario = $data['usuario'];
        $dato->fecha = $data['fecha'];

        /*$dato->codigo = $data['codigo'];
        $dato->nombre = $data['nombre'];
        $dato->feria = $data['feria'];
        $dato->version = $data['version'];
        $dato->fecha_inicio = $data['fecha_inicio'];
        $dato->fecha_final = $data['fecha_final'];
        $dato->estado = $data['estado'];
        $dato->pro_id = $data['pro_id'];
        $dato->fev_id = $data['fev_id'];*/
        $dato->save();
        return $dato->fresh();
    }

    public function getById($cer_id){
        return $this->certificado->find($cer_id);
    }

    public function getByProductorAndFeria($pro_id,$fev_id)
    {
        return $this->certificado->where([
            ['estado','=','AC'],
            ['pro_id','=',$pro_id],
            ['fev_id','=',$fev_id]
        ])->first();
    }

    public function getAllByFeria($fev_id)
    {
        return $this->certificado->where([
            ['estado','=','AC'],
            ['fev_id','=',$fev_id]
        ])->orderBy('nombre','asc')->get();
    }

}
