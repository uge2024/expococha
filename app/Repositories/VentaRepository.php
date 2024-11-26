<?php


namespace App\Repositories;


use App\Models\FeriaProducto;
use App\Models\Producto;
use App\Models\Venta;

class VentaRepository
{
    protected $venta;
    public function __construct(Venta $venta)
    {
        $this->venta = $venta;
    }

    public function save($data)
    {
        $venta = new $this->venta;
        $venta->tipo_pago = $data['tipo_pago'];
        $venta->estado_venta = $data['estado_venta'];
        $venta->estado_delivery = $data['estado_delivery'];
        $venta->estado = $data['estado'];
        $venta->cantidad = $data['cantidad'];
        $venta->precio_venta = $data['precio_venta'];
        $venta->subtotal =$data['subtotal'];
        $venta->precio_base_delivery = $data['precio_base_delivery'];
        $venta->fecha = $data['fecha'];
        $venta->usr_id = $data['usr_id'];
        $venta->del_id = $data['del_id'];
        if (isset($data['comprobante'])){
            $venta->comprobante = $data['comprobante'];
        }
        if (isset($data['prd_id'])){
            $venta->prd_id = $data['prd_id'];
        }
        if (isset($data['fpr_id'])){
            $venta->fpr_id = $data['fpr_id'];
        }
        $venta->save();
        return $venta->fresh();
    }

    public function updateEstadoDelivery($ven_id,$estado_delivery)
    {
        $venta = $this->venta->find($ven_id);
        $venta->estado_delivery = $estado_delivery;
        $venta->save();
        return $venta->fresh();
    }

    public function updateEstadoVenta($ven_id,$estado_venta)
    {
        $venta = $this->venta->find($ven_id);
        $venta->estado_venta = $estado_venta;
        $venta->save();
        return $venta->fresh();
    }

    public function getById($ven_id)
    {
        return $this->venta->find($ven_id);
    }

    public function getAll()
    {
        return $this->venta->all();
    }

    public function getAllByPaginateAndSearchAndSort($limit,$searchtype,$search,$sort)
    {
        /*$campoSearch = $searchtype==1?'name':'email';
        $sortCampo = $sort==1?'name':($sort==2?'email':'rol');
        return $this->venta->whereRaw(
            "UPPER($campoSearch) like '%".strtoupper($search)."%'"
        )->orderBy($sortCampo,'asc')->paginate($limit);*/
        return $this->venta->paginate($limit);
    }

    public function getAllVentasByUsrIdAndPaginateAndSortByFecha($usr_id,$limit)
    {
        return $this->venta->where([
            ['usr_id','=',$usr_id]
        ])->orderBy('fecha','desc')->paginate($limit);
    }

    public function marcarVentaComoConfirmada($ven_id,$estado_venta,$estado_delivery)
    {
        //actualizamos los estados de la venta
        $venta = $this->venta->find($ven_id);
        $venta->estado_delivery = $estado_delivery;
        $venta->estado_venta = $estado_venta;
        $venta->save();
        //restamos los productos del stock del producto o del producto feria
        if (isset($venta->prd_id)){
            $producto = Producto::find($venta->prd_id);
            $existencia = $producto->existencia;
            if ($existencia >= $venta->cantidad){
                $producto->existencia = $existencia-$venta->cantidad;
            }else{
                $producto->existencia = 0;
            }
            $producto->save();
        }
        if (isset($venta->fpr_id)){
            $producto = FeriaProducto::find($venta->fpr_id);
            $existencia = $producto->existencia;
            if ($existencia >= $venta->cantidad){
                $producto->existencia = $existencia-$venta->cantidad;
            }else{
                $producto->existencia = 0;
            }
            $producto->save();
        }
        return $venta->fresh();
    }

    public function getAllVentasByProIdAndPaginateAndSortByFecha($pro_id,$limit,$searchtype,$search,$sort)
    {
        $manera = 'desc';
        $campoSort = 'fecha';
        $whereUsuario = " true ";
        $whereProducto = " true ";
        $whereFeriaProducto = " true ";
        switch ($sort){
            case 1:
                $campoSort = 'fecha';
                $manera = 'desc';
                break;
            default:
                $campoSort = 'fecha';
                $manera = 'desc';
        }
        switch ($searchtype){
            case 1:
                $whereUsuario = "UPPER(name) like '%".strtoupper($search)."%'";
                break;
            case 2:
                $whereProducto = "UPPER(nombre_producto) like '%".strtoupper($search)."%'";
                $whereFeriaProducto = "UPPER(nombre_producto) like '%".strtoupper($search)."%'";
            default:

        }

        return $this->venta
            ->whereHas('usuario',function ($query1) use($whereUsuario){
                $query1->whereRaw($whereUsuario);
            })
            ->where(function ($query2) use($pro_id,$whereProducto,$whereFeriaProducto){
                $query2->whereHas('producto', function ($query3) use($pro_id,$whereProducto){
                    $query3->where([
                        ['pro_id','=',$pro_id]
                    ])
                    ->whereRaw($whereProducto);
                })->orWhereHas('feriaProducto', function ($query4) use($pro_id,$whereFeriaProducto){
                    $query4->where([
                        ['pro_id','=',$pro_id]
                    ])
                    ->whereRaw($whereFeriaProducto);
                });
            })
            ->orderBy($campoSort,$manera)->paginate($limit);
    }

    public function updateDeliveryAndTotal($ven_id,$del_id,$precio_base_delivery,$subtotal)
    {
        $venta = $this->venta->find($ven_id);
        $venta->del_id = $del_id;
        $venta->subtotal = $subtotal;
        $venta->precio_base_delivery = $precio_base_delivery;
        $venta->save();
        return $venta->fresh();
    }

    public function getAllVentasPaginateAndSearchAndSort($limit,$searchtype,$search,$sort)
    {
        $manera = 'desc';
        $campoSort = 'fecha';
        $whereUsuario = " true ";
        $whereProducto = " true ";
        $whereFeriaProducto = " true ";
        switch ($sort){
            case 1:
                $campoSort = 'fecha';
                $manera = 'desc';
                break;
            default:
                $campoSort = 'fecha';
                $manera = 'desc';
        }
        switch ($searchtype){
            case 1:
                $whereUsuario = "UPPER(name) like '%".strtoupper($search)."%'";
                break;
            case 2:
                $whereProducto = "UPPER(nombre_producto) like '%".strtoupper($search)."%'";
                $whereFeriaProducto = "UPPER(nombre_producto) like '%".strtoupper($search)."%'";
            default:

        }

        return $this->venta
            ->whereHas('usuario',function ($query1) use($whereUsuario){
                $query1->whereRaw($whereUsuario);
            })
            ->where(function ($query2) use($whereProducto,$whereFeriaProducto){
                $query2->whereHas('producto', function ($query3) use($whereProducto){
                    $query3->whereRaw($whereProducto);
                })->orWhereHas('feriaProducto', function ($query4) use($whereFeriaProducto){
                    $query4->whereRaw($whereFeriaProducto);
                });
            })
            ->orderBy($campoSort,$manera)->paginate($limit);
    }

}
