<?php
namespace App\Repositories;
use App\Models\FeriaProductor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FeriaProductorRepository
{

    protected $feriaProductor;
    public function __construct(FeriaProductor $feriaProductor)
    {
        $this->feriaProductor = $feriaProductor;
    }

    public function getAllPaginate($limit)
    {
        return $this->feriaProductor->where([
        ])->orderBy('fecha_inscripcion','asc')->paginate($limit);
    }

    public function getById($fpd_id):?FeriaProductor
    {
        $feriaProductor = FeriaProductor::find($fpd_id);
        return $feriaProductor;
    }

    public function save($data):?FeriaProductor
    {
        $feriaProductor = new $this->feriaProductor;
        $feriaProductor->fecha_inscripcion = $data['fecha_inscripcion'];
        $feriaProductor->comprobante = $data['comprobante'];
        $feriaProductor->monto = $data['monto'];
        if(isset($data['comprobante'])){
            $feriaProductor->comprobante = $data['comprobante'];
        }else{
            $feriaProductor->comprobante = null;
        }
        if(isset($data['monto'])){
            $feriaProductor->monto = $data['monto'];
        }else{
            $feriaProductor->monto = null;
        }
        if(isset($data['fecha_pago'])){
            $feriaProductor->fecha_pago = $data['fecha_pago'];
        }else{
            $feriaProductor->fecha_pago = null;
        }
        $feriaProductor->usr_id = $data['usr_id'];
        $feriaProductor->fev_id = $data['fev_id'];
        $feriaProductor->pro_id = $data['pro_id'];
        $feriaProductor->estado = 'AC';

        $feriaProductor->save();
        return $feriaProductor->fresh();
    }

    public function getFeriaProductorByferia($fev_id,$limit)
    {
        $feriaProductor = FeriaProductor::where([
            ['fev_id','=',$fev_id]
        ])->orderBy('fecha_inscripcion','asc')->paginate($limit);

        return $feriaProductor;
    }

    public function update($data):?FeriaProductor
    {
        $feriaProductor = FeriaProductor::find($data['fpd_id']);
        $feriaProductor->fecha_inscripcion = $data['fecha_inscripcion'];
        $feriaProductor->comprobante = $data['comprobante'];
        $feriaProductor->monto = $data['monto'];
        if(isset($data['comprobante'])){
            $feriaProductor->comprobante = $data['comprobante'];
        }else{
            $feriaProductor->comprobante = null;
        }
        if(isset($data['monto'])){
            $feriaProductor->monto = $data['monto'];
        }else{
            $feriaProductor->monto = null;
        }
        if(isset($data['fecha_pago'])){
            $feriaProductor->fecha_pago = $data['fecha_pago'];
        }else{
            $feriaProductor->fecha_pago = null;
        }
        $feriaProductor->usr_id = $data['usr_id'];
        $feriaProductor->fev_id = $data['fev_id'];
        $feriaProductor->pro_id = $data['pro_id'];
        $feriaProductor->estado = 'AC';

        $feriaProductor->save();
        return $feriaProductor->fresh();
    }


    public function delete($data,$texto):?FeriaProductor
    {
        $feriaProductor = FeriaProductor::find($data['fpd_id']);
        if($texto == 'inhabilitar') {
            $feriaProductor->estado = 'EL';
            $feriaProductor->save();
            return $feriaProductor->fresh();
        }
        if($texto == 'habilitar'){
            $feriaProductor->estado = 'AC';
            $feriaProductor->save();
            return $feriaProductor->fresh();
        }
    }

    public function ExisteFeriaProductor($fev_id,$pro_id)
    {
        $feriaProductor = FeriaProductor::where([
            ['fev_id','=',$fev_id],
            ['pro_id','=',$pro_id]
        ])->get();

        return $feriaProductor;
    }


    public function getFeriaVirtualOfferiaProductorComboByProductor($pro_id)
    {
        $listaFeriaProductor = FeriaProductor::select(
        DB::raw("CONCAT(fev_feria_virtual.nombre) AS nombre"),'fpd_feria_productor.fpd_id')
                  ->join('fev_feria_virtual','fpd_feria_productor.fev_id', '=', 'fev_feria_virtual.fev_id')
                  ->where([['fev_feria_virtual.estado','=','AC'],
                           ['fpd_feria_productor.pro_id','=',$pro_id]])
                  ->pluck("nombre",'fpd_id','listaFeriaProductor')->prepend('Seleccione un feria ','0') ;
        return $listaFeriaProductor;
    }

    public function getFeriaProductorByProductor($pro_id,$limit)
    {
        $feriaProductor = FeriaProductor::where([
            ['pro_id','=',$pro_id]
        ])->orderBy('fecha_inscripcion','asc')->paginate($limit);

        return $feriaProductor;
    }

    public function getFeriaProductorByProductorPaginateBySearchAndSort($limit,$pro_id,$searchtype,$search,$sort)
    {
     /*   $sortCampo = $sort==1?'fpd_feria_productor.nombre_producto':($sort==2?'fpd_feria_productor.descripcion1':($sort==3?'fpd_feria_productor.existencia':'fpd_feria_productor.precio'));
        $where = array();
        $whereRaw = ' true ';
        array_push($where, ['fpd_feria_productor.pro_id','=',$pro_id]);
        if (!empty($search)){
            $campoSearch = $searchtype==1?'prd_producto.nombre_producto':'prd_producto.descripcion1';
            $whereRaw = " UPPER($campoSearch) like '%".strtoupper($search)."%' ";
        }
        return $this->feriaProductor->where($where)
            ->whereRaw($whereRaw)
            ->orderBy($sortCampo,'asc')
            ->paginate($limit);
       */
        $feriaProductor = FeriaProductor::where([
            ['pro_id','=',$pro_id]
        ])->orderBy('fecha_inscripcion','asc')->paginate($limit);

        return $feriaProductor;


    }




}
