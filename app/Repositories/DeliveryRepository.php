<?php
namespace App\Repositories;

use App\Models\Delivery;
use Notification;
use Toastr;


class DeliveryRepository
{

    protected $delivery;
    public function __construct(Delivery $delivery)
    {
        $this->delivery = $delivery;
    }

    public function getAllPaginateDeliveryByProductor($limit,$pro_id)
    {
        return $this->delivery->where([
            ['pro_id','=',$pro_id]
        ])->orderBy('razon_social','asc')->paginate($limit);
    }

    public function getAllPaginateDeliveryByProductorAC($limit,$pro_id)
    {
        return $this->delivery->where([
            ['estado','=','AC'],
            ['pro_id','=',$pro_id]
        ])->orderBy('razon_social','asc')->paginate($limit);
    }

    public function save($data):?Delivery
    {
        $delivery = new $this->delivery;
        $delivery->razon_social = $data['razon_social'];
        if(isset($data['propietario'])){
            $delivery->propietario = $data['propietario'];
        }else{
            $delivery->propietario = null;
        }
        if(isset($data['costo_minimo'])){
            $delivery->costo_minimo = $data['costo_minimo'];
        }else{
            $delivery->costo_minimo = null;
        }
        if(isset($data['costo_maximo'])){
            $delivery->costo_maximo = $data['costo_maximo'];
        }else{
            $delivery->costo_maximo = null;
        }
        $delivery->tipo_transporte = $data['tipo_transporte'];
        $delivery->disponible = $data['disponible'];
        $delivery->estado = 'AC';
        $delivery->pro_id = $data['pro_id'];
        $delivery->save();
        return $delivery->fresh();
    }

    public function getById($del_id):?Delivery
    {
        $delivery = Delivery::find($del_id);
        return $delivery;
    }

    public function update($data)
    {
        $delivery = Delivery::find($data['del_id']);
        if($data['razon_social'] != 'Sin delivery' ) {
            $delivery->razon_social = $data['razon_social'];
            if (isset($data['propietario'])) {
                $delivery->propietario = $data['propietario'];
            } else {
                $delivery->propietario = null;
            }
            if (isset($data['costo_minimo'])) {
                $delivery->costo_minimo = $data['costo_minimo'];
            } else {
                $delivery->costo_minimo = null;
            }
            if (isset($data['costo_maximo'])) {
                $delivery->costo_maximo = $data['costo_maximo'];
            } else {
                $delivery->costo_maximo = null;
            }
            $delivery->tipo_transporte = $data['tipo_transporte'];
            $delivery->disponible = $data['disponible'];
            $delivery->estado = 'AC';
            $delivery->pro_id = $data['pro_id'];
            $delivery->save();
            return $delivery->fresh();
        }
    }

    public function delete($data,$texto):?Delivery
    {
        $delivery = Delivery::find($data['del_id']);
        if($texto == 'inhabilitar') {
            $delivery->estado = 'EL';
            $delivery->save();
            return $delivery->fresh();
        }
        if($texto == 'habilitar'){
            $delivery->estado = 'AC';
            $delivery->save();
            return $delivery->fresh();
        }
    }

    public function getAllAcByProductor($pro_id)
    {
        return $this->delivery->where([
            ['pro_id','=',$pro_id],
            ['estado','=','AC']
        ])->orderBy('razon_social','asc')->get();
    }
}
