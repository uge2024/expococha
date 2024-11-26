<?php
namespace App\Repositories;

use App\Models\FeriaProducto;
use Illuminate\Support\Facades\DB;

class FeriaProductoRepository
{
    protected $feriaProducto;
    public function __construct(FeriaProducto $feriaProducto)
    {
        $this->feriaProducto = $feriaProducto;
    }

    //Guardar solo los datos del producto
    public function save($data):?FeriaProducto
    {
        $feriaProducto = new $this->feriaProducto;
        $feriaProducto->nombre_producto = $data['nombre_producto'];
        $feriaProducto->existencia = $data['existencia'];
        $feriaProducto->puntuacion = 3;
        $feriaProducto->descripcion1 = $data['descripcion1'];
        $feriaProducto->descripcion2 = $data['descripcion2'];
        $feriaProducto->precio = $data['precio'];
        if(isset($data['precio_oferta'])){
            $feriaProducto->precio_oferta = $data['precio_oferta'];
        }else{
            $feriaProducto->precio_oferta = null;
        }
        if(isset($data['descuento'])){
            $feriaProducto->descuento = $data['descuento'];
        }else{
            $feriaProducto->descuento = null;
        }
        if(isset($data['fecha_modificacion'])){
            $feriaProducto->fecha_modificacion = $data['fecha_modificacion'];
        }else{
            $feriaProducto->fecha_modificacion = null;
        }
       if(isset($data['codigo_qr_venta'])){
            $feriaProducto->codigo_qr_venta = $data['codigo_qr_venta'];
        }else{
            $feriaProducto->codigo_qr_venta = null;
        }
        $feriaProducto->existencia_minima = $data['existencia_minima'];
        $feriaProducto->fecha_registro = $data['fecha_registro'];
        $feriaProducto->estado = $data['estado'];
        $feriaProducto->cat_id = $data['cat_id'];
        $feriaProducto->pro_id = $data['pro_id'];
       if(isset($data['prd_id'])){
            $feriaProducto->prd_id = $data['prd_id'];
        }else{
            $feriaProducto->prd_id = null;
        }

        $feriaProducto->fpd_id = $data['fpd_id'];
        $feriaProducto->save();
        return $feriaProducto->fresh();
    }

    public function getById($fpr_id):?FeriaProducto
    {
        $feriaProducto = FeriaProducto::find($fpr_id);
        return $feriaProducto;
    }

    public function update($data):?FeriaProducto
    {
        $feriaProducto = FeriaProducto::find($data['fpr_id']);
        $feriaProducto->nombre_producto = $data['nombre_producto'];
        $feriaProducto->existencia = $data['existencia'];
        $feriaProducto->descripcion1 = $data['descripcion1'];
        $feriaProducto->descripcion2 = $data['descripcion2'];
        $feriaProducto->precio = $data['precio'];
        if(isset($data['fecha_modificacion'])){
            $feriaProducto->fecha_modificacion = $data['fecha_modificacion'];
        }else{
            $feriaProducto->fecha_modificacion = null;
        }
        if(isset($data['codigo_qr_venta'])){
            $feriaProducto->codigo_qr_venta = $data['codigo_qr_venta'];
        }
        /*else{
            $producto->codigo_qr_venta = null;
        }*/
        $feriaProducto->existencia_minima = $data['existencia_minima'];
        //$producto->fecha_registro = $data['fecha_registro'];
        $feriaProducto->estado = $data['estado'];
        $feriaProducto->cat_id = $data['cat_id'];
        $feriaProducto->pro_id = $data['pro_id'];

        $feriaProducto->fpd_id = $data['fpd_id'];
        if(isset($data['prd_id'])){
            $feriaProducto->prd_id = $data['prd_id'];
        }else{
            $feriaProducto->prd_id = null;
        }

        $feriaProducto->save();
        return $feriaProducto->fresh();
    }

    public function delete($data,$texto):?FeriaProducto
    {
        $feriaProducto = FeriaProducto::find($data['fpr_id']);
        if($texto == 'inhabilitar') {
            $feriaProducto->estado = 'EL';
            $feriaProducto->save();
            return $feriaProducto->fresh();
        }
        if($texto == 'habilitar'){
            $feriaProducto->estado = 'AC';
            $feriaProducto->save();
            return $feriaProducto->fresh();
        }

    }

    public function getFeriaProductoByferiaProductor($fpd_id,$limit)
    {
        return $this->feriaProducto->where([
            ['fpd_id','=',$fpd_id],
            ['estado','=','AC']
        ])->paginate($limit);
    }

    //lista los productos de un productor con estado AC y EL
    public function getAllPaginateBySearchAndSortACAndEl($limit,$fpd_id,$searchtype,$search,$sort)
    {
        $sortCampo = $sort==1?'fpr_feria_producto.nombre_producto':($sort==2?'fpr_feria_producto.descripcion1':($sort==3?'fpr_feria_producto.existencia':'fpr_feria_producto.precio'));
        $where = array();
        $whereRaw = ' true ';
        array_push($where, ['fpr_feria_producto.fpd_id','=',$fpd_id]);
        if (!empty($search)){
            $campoSearch = $searchtype==1?'fpr_feria_producto.nombre_producto':'fpr_feria_producto.descripcion1';
            $whereRaw = " UPPER($campoSearch) like '%".strtoupper($search)."%' ";
        }
        return $this->feriaProducto->where($where)
            ->whereRaw($whereRaw)
            ->orderBy($sortCampo,'asc')
            ->paginate($limit);
    }




}
