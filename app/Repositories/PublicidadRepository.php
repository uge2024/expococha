<?php


namespace App\Repositories;


use App\Models\Publicidad;

class PublicidadRepository
{
    protected $publicidad;
    public function __construct(Publicidad $publicidad)
    {
        $this->publicidad = $publicidad;
    }

    public function getAllPaginate($limit)
    {
        return $this->publicidad->where([

        ])->orderBy('fecha_desde','desc')->paginate($limit);
    }

    public function save($data):?Publicidad
    {
        $publicidad = new $this->publicidad;
        $publicidad->fecha_desde = $data['fecha_desde'];
        $publicidad->fecha_hasta = $data['fecha_hasta'];
        $publicidad->solicitante = $data['solicitante'];
        $publicidad->documento = $data['documento'];
        if(isset($data['doc_pago'])){
            $publicidad->doc_pago = $data['doc_pago'];
        }else{
            $publicidad->doc_pago = null;
        }
        if(isset($data['fecha_pago'])){
            $publicidad->fecha_pago = $data['fecha_pago'];
        }else{
            $publicidad->fecha_pago = null;
        }
        if(isset($data['monto'])){
            $publicidad->monto = $data['monto'];
        }else{
            $publicidad->monto = null;
        }
        $publicidad->link_destino = $data['link_destino'];
        $publicidad->imagen = $data['imagen'];
        $publicidad->estado = 'AC';
        $publicidad->tpu_id = $data['tpu_id'];
        $publicidad->save();
        return $publicidad->fresh();
    }

    public function getById($pub_id):?Publicidad
    {
        $publicidad = Publicidad::find($pub_id);
        return $publicidad;
    }

    public function update($data):?Publicidad
    {
        $publicidad = Publicidad::find($data['pub_id']);
        $publicidad->fecha_desde = $data['fecha_desde'];
        $publicidad->fecha_hasta = $data['fecha_hasta'];
        $publicidad->solicitante = $data['solicitante'];
        $publicidad->documento = $data['documento'];
        if(isset($data['doc_pago'])){
            $publicidad->doc_pago = $data['doc_pago'];
        }else{
            $publicidad->doc_pago = null;
        }
        if(isset($data['fecha_pago'])){
            $publicidad->fecha_pago = $data['fecha_pago'];
        }else{
            $publicidad->fecha_pago = null;
        }
        if(isset($data['monto'])){
            $publicidad->monto = $data['monto'];
        }else{
            $publicidad->monto = null;
        }
        $publicidad->link_destino = $data['link_destino'];

        if(isset($data['imagen'])){
            $publicidad->imagen = $data['imagen'];
        }

        $publicidad->estado = 'AC';
        $publicidad->tpu_id = $data['tpu_id'];
        $publicidad->save();
        return $publicidad->fresh();
    }


    public function delete($data,$texto):?Publicidad
    {
        $publicidad = Publicidad::find($data['pub_id']);
        if($texto == 'inhabilitar') {
            $publicidad->estado = 'EL';
            $publicidad->save();
            return $publicidad->fresh();
        }
        if($texto == 'habilitar'){
            $publicidad->estado = 'AC';
            $publicidad->save();
            return $publicidad->fresh();
        }

    }

    public function getAllPublicidadVigenteByTpuId($tpu_id)
    {
        $fecha_actual = date('Y-m-d');
        return $this->publicidad->where([
            ['estado','=','AC'],
            ['tpu_id','=',$tpu_id],
            ['fecha_desde','<=',$fecha_actual],
            ['fecha_hasta','>=',$fecha_actual]
        ])->get();
    }

}
