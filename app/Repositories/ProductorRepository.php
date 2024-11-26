<?php


namespace App\Repositories;


use App\Models\FeriaVirtual;
use App\Models\ImagenProductor;
use App\Models\Producto;
use App\Models\Productor;
use App\Models\Rubro;
use App\Models\ValoracionProductor;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ProductorRepository
{
    protected $productor;
    protected $producto;
    protected $imagenProductor;
    public function __construct(Productor $productor, ImagenProductor $imagenProductor,Producto $producto)
    {
        $this->productor = $productor;
        $this->imagenProductor = $imagenProductor;
        $this->producto = $producto;
    }

    public function getAllPaginate($limit)
    {
        return $this->productor->where([
            ['estado','=','AC']
        ])->orderBy('nombre_tienda','asc')->paginate($limit);
    }

    public function save($data):?Productor
    {
        $productor = new $this->productor;
        $productor->nombre_propietario = $data['nombre_propietario'];
        $productor->fecha_registro = $data['fecha_registro'];
        $productor->direccion = $data['direccion'];
        if($data['telefono_1']){  $productor->telefono_1 = $data['telefono_1']; }else{ $productor->telefono_1 = null;  }
        if($data['telefono_2']){  $productor->telefono_2 = $data['telefono_2']; }else{ $productor->telefono_2 = null;  }
        $productor->celular = $data['celular'];
        $productor->celular_wp = $data['celular_wp'];
        $productor->nombre_tienda = $data['nombre_tienda'];
        $productor->actividad = $data['actividad'];
        $productor->email = $data['email'];
        if($data['puntuacion']){  $productor->puntuacion = $data['puntuacion']; }else{ $productor->puntuacion = null;  }
        if($data['cuenta']){  $productor->cuenta = $data['cuenta']; }else{ $productor->cuenta = null;  }
        if($data['entidad_financiera']){  $productor->entidad_financiera = $data['entidad_financiera']; }else{ $productor->entidad_financiera = null;  }
        if($data['longitud']){  $productor->longitud = $data['longitud']; }else{ $productor->longitud = null;  }
        if($data['latitud']){  $productor->latitud = $data['latitud']; }else{ $productor->latitud = null;  }
        if($data['link_facebook']){  $productor->link_facebook = $data['link_facebook']; }else{ $productor->link_facebook = null;  }
        if($data['link_twiter']){  $productor->link_twiter = $data['link_twiter']; }else{ $productor->link_twiter = null;  }
        if($data['link_instagram']){  $productor->link_instagram = $data['link_instagram']; }else{ $productor->link_instagram = null;  }
        if($data['link_youtube']){  $productor->link_youtube = $data['link_youtube']; }else{ $productor->link_youtube = null;  }
        if($data['titular_cuenta']){  $productor->titular_cuenta = $data['titular_cuenta']; }else{ $productor->titular_cuenta = null;  }

        $productor->estado = $data['estado'];
        $productor->estado_tienda = $data['estado_tienda'];
        $productor->rub_id = $data['rub_id'];
        $productor->usr_id = $data['usr_id'];
        $productor->aso_id = $data['aso_id'];
        $productor->puntuacion = 3;
        $productor->save();
        return $productor->fresh();
    }

    public function getById($pro_id):?Productor
    {
        $productor = Productor::find($pro_id);
        return $productor;

    }

    public function getProductorByProducto($prd_id):?Productor
    {
        $producto = Producto::find($prd_id);
        $productor = Productor::find($producto->pro_id);
        return $productor;
    }

    public function update($data):?Productor
    {
        $productor = Productor::find($data['pro_id']);
        $productor->nombre_propietario = $data['nombre_propietario'];
        //$productor->fecha_registro = $data['fecha_registro'];
        $productor->direccion = $data['direccion'];
        if($data['telefono_1']){  $productor->telefono_1 = $data['telefono_1']; }else{ $productor->telefono_1 = null;  }
        if($data['telefono_2']){  $productor->telefono_2 = $data['telefono_2']; }else{ $productor->telefono_2 = null;  }
        $productor->celular = $data['celular'];
        $productor->celular_wp = $data['celular_wp'];
        $productor->nombre_tienda = $data['nombre_tienda'];
        $productor->actividad = $data['actividad'];
        $productor->email = $data['email'];
        //if($data['puntuacion']){  $productor->puntuacion = $data['puntuacion']; }else{ $productor->puntuacion = null;  }
        if($data['cuenta']){  $productor->cuenta = $data['cuenta']; }else{ $productor->cuenta = null;  }
        if($data['entidad_financiera']){  $productor->entidad_financiera = $data['entidad_financiera']; }else{ $productor->entidad_financiera = null;  }
        if($data['longitud']){  $productor->longitud = $data['longitud']; }else{ $productor->longitud = null;  }
        if($data['latitud']){  $productor->latitud = $data['latitud']; }else{ $productor->latitud = null;  }
        if($data['link_facebook']){  $productor->link_facebook = $data['link_facebook']; }else{ $productor->link_facebook = null;  }
        if($data['link_twiter']){  $productor->link_twiter = $data['link_twiter']; }else{ $productor->link_twiter = null;  }
        if($data['link_instagram']){  $productor->link_instagram = $data['link_instagram']; }else{ $productor->link_instagram = null;  }
        if($data['link_youtube']){  $productor->link_youtube = $data['link_youtube']; }else{ $productor->link_youtube = null;  }
        if($data['titular_cuenta']){  $productor->titular_cuenta = $data['titular_cuenta']; }else{ $productor->titular_cuenta = null;  }
        $productor->estado = $data['estado'];
        $productor->estado_tienda = $data['estado_tienda'];
        $productor->rub_id = $data['rub_id'];
        $productor->usr_id = $data['usr_id'];
        $productor->aso_id = $data['aso_id'];
        $productor->save();
        return $productor->fresh();
    }

    public function delete($data):?Productor
    {
        $productor = Productor::find($data['pro_id']);
        $productor->estado = 'EL';
        $productor->save();
        return $productor->fresh();
    }

    public function getProductorByUser($usr_id):?Productor
    {
        return Productor::where('usr_id','=',$usr_id)->where('estado','=','AC')->first();
    }

    public function getAllPaginateBySearchAndSort($limit,$searchtype,$search,$sort)
    {
        /*$campoSearch = $searchtype==1?'nombre_propietario':'nombre_tienda';
        $sortCampo = $sort==1?'nombre_propietario':($sort==2?'nombre_tienda':'email');
        return $this->productor->whereRaw(
            "UPPER($campoSearch) like '%".strtoupper($search)."%'"
        )->orderBy($sortCampo,'asc')->with('usuario','rubro')->paginate($limit);*/

        $sortCampo = $sort==1?'pro.nombre_propietario':($sort==2?'pro.nombre_tienda':($sort==3?'pro.email':'rub.nombre'));
        $where = array();
        $whereRaw = ' true ';
        array_push($where, ['use.rol','=',2]);
        if (!empty($search)){
            $campoSearch = 'pro.nombre_propietario';
            if ($searchtype == 1){
                $campoSearch = 'pro.nombre_propietario';
            }elseif ($searchtype == 2){
                $campoSearch = 'pro.nombre_tienda';
            }elseif ($searchtype == 3){
                $campoSearch = 'use.name';
            }
            $whereRaw = " UPPER($campoSearch) like '%".strtoupper($search)."%' ";
        }
        return DB::table('users as use')
            ->leftJoin('pro_productor as pro','use.id','pro.usr_id')
            ->leftJoin('rub_rubro as rub','rub.rub_id','pro.rub_id')
            ->where($where)
            ->whereRaw($whereRaw)
            ->select('use.id as usr_id'
                ,'use.name as name'
                ,'pro.pro_id as pro_id'
                ,'pro.nombre_propietario as nombre_propietario'
                ,'pro.nombre_tienda as nombre_tienda'
                ,'pro.email as email'
                ,'rub.nombre as rubro'
                ,'pro.estado as estado'
                ,'pro.estado_tienda as estado_tienda'
                ,'pro.direccion as direccion'
                ,'pro.celular as celular')
            ->orderBy($sortCampo,'asc')
            ->paginate($limit);

    }

    public function updateEstadoTienda($pro_id,$estado_tienda)
    {
        $productor = Productor::find($pro_id);
        $productor->estado_tienda = $estado_tienda;
        $productor->save();
        return $productor->fresh();
    }

    public function getByIdWithValoracionesAndImagenesAndProductos($pro_id):?Productor
    {
        $productor = Productor::where([
            ['pro_id','=',$pro_id]
        ])->with(['imagenProductores','valoracionesProductor'])->first();
        return $productor;
    }

    public function getProductoresByRubro($rub_id):?Collection
    {
        return $this->productor->where([
            ['estado','=','AC'],
            ['rub_id','=',$rub_id],
        ])->orderBy('nombre_tienda','asc')->get();
    }

    public function getProductorComboByFeria($fev_id)
    {
        $feriaVirtual = FeriaVirtual::find($fev_id);
        $rubro = Rubro::find($feriaVirtual->rub_id);
        $listaProductores = Productor::select(
        DB::raw("CONCAT(pro_productor.nombre_tienda,' - ',pro_productor.nombre_propietario,' - ',aso_asociacion.nombre) AS nombre"),'pro_productor.pro_id')
                  ->join('rub_rubro','pro_productor.rub_id', '=', 'rub_rubro.rub_id')
                  ->join('aso_asociacion','pro_productor.aso_id', '=', 'aso_asociacion.aso_id')
                  ->where([['pro_productor.estado','=','AC'],
                           ['pro_productor.rub_id','=',$rubro->rub_id]])->pluck("nombre",'pro_id','listaProductores')->prepend('Seleccione un Productor','0') ;
        /*
                DB::raw("CONCAT(pro_productor.nombre_tienda,' - ',pro_productor.nombre_propietario,' - ',aso_asociacion.nombre) AS nombre"),'pro_productor.pro_id')
                  ->join('rub_rubro','pro_productor.rub_id', '=', 'rub_rubro.rub_id')
                  ->join('aso_asociacion','pro_productor.aso_id', '=', 'aso_asociacion.aso_id')
                  ->where([['pro_productor.estado','=','AC'],
                           ['pro_productor.rub_id','=',$rubro->rub_id]])
                  ->whereNotExists(function($query)
                    {
                    $query->select('fpd_feria_productor.pro_id')
                          ->from('fpd_feria_productor')->where([['fpd_feria_productor.estado','=','AC'],])
                         ->whereRaw("pro_productor.pro_id = fpd_feria_productor.pro_id");
                    })->pluck("nombre",'pro_id','listaProductores')->prepend('Seleccione un Productor','0') ;
                    */
        return $listaProductores;
    }

    public function getAllProductosAcByProductorAndSortAndLimit($pro_id,$inicio,$limit,$orden)
    {
        $campoSort = 'nombre_producto';
        $maneraOrden = 'asc';
        switch ($orden){
            case 1://nombre
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
                break;
            case 2://puntuacion
                $campoSort = 'puntuacion';
                $maneraOrden = 'desc';
                break;
            case 3://precio
                $campoSort = 'precio';
                $maneraOrden = 'asc';
                break;
            default:
                $campoSort = 'nombre_producto';
                $maneraOrden = 'asc';
        }
        return $this->producto::where([
            ['estado','=','AC']
        ])->whereHas('productor', function ($query) use($pro_id){
            $query->where([
                ['estado_tienda', 'like', 'AC'],
                ['pro_id','=',$pro_id]
            ]);
        })->orderBy($campoSort,$maneraOrden)
            ->with(['imagenesProducto'])->skip($inicio)->take($limit)->get();
    }

    public function getAllProductosAcByProductor($pro_id)
    {
        return $this->producto::where([
            ['estado','=','AC']
        ])->whereHas('productor', function ($query) use($pro_id){
            $query->where([
                ['pro_id','=',$pro_id]
            ]);
        })->orderBy('fecha_registro','asc')
            ->with(['imagenesProducto'])->get();
    }

    public function getProductorComboByRubro($rub_id)
    {
        $listaProductores = Productor::select(
            DB::raw("CONCAT(pro_productor.nombre_tienda,' - ',pro_productor.nombre_propietario,' - ',aso_asociacion.nombre) AS nombre"),'pro_productor.pro_id')
            ->join('rub_rubro','pro_productor.rub_id', '=', 'rub_rubro.rub_id')
            ->join('aso_asociacion','pro_productor.aso_id', '=', 'aso_asociacion.aso_id')
            ->where([['pro_productor.estado','=','AC'],
                ['pro_productor.rub_id','=',$rub_id]])->pluck("nombre",'pro_id','listaProductores')->prepend('Seleccione un Productor','') ;

        return $listaProductores;
    }

    public function getAllProductoresByFeriaVirtual($fev_id)
    {
        return $this->productor->whereHas('feriaProductores',function ($query1) use ($fev_id){
           $query1->where([
              ['estado','=','AC'],
              ['fev_id','=',$fev_id]
           ]);
        })->orderBy('nombre_propietario','asc')->get();
    }
}
