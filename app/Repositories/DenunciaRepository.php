<?php
namespace App\Repositories;
use App\Models\Denuncia;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
class DenunciaRepository
{
    protected $denuncia;
    public function __construct(Denuncia $denuncia)
    {
        $this->denuncia = $denuncia;
    }

    public function getAllPaginate($limit)
    {
        return $this->denuncia->where([
        ])->orderBy('estado_visto','asc')->paginate($limit);
    }

    public function getAllByAc(): Collection
    {
        return $this->denuncia->where([
            ['estado','=','AC']
        ])->orderBy('estado_visto','asc')->get();
    }

    public function save($data):?Denuncia
    {
        $denuncia = new $this->denuncia;
        $denuncia->estado_visto = 1;
        $denuncia->estado = 'AC';
        $denuncia->fecha = $data['fecha'] = date('Y-m-d H:i:s');
        $denuncia->usr_id = $data['usr_id'];
        $denuncia->denuncia = $data['denuncia'];
        if(isset($data['prd_id'])){
            $denuncia->prd_id = $data['prd_id'];
        }else{
            $denuncia->prd_id = null;
        }
        if(isset($data['pro_id'])){
            $denuncia->pro_id = $data['pro_id'];
        }else{
            $denuncia->pro_id = null;
        }
/*
        if(isset($data['fpr_id'])){
            $denuncia->fpr_id = $data['fpr_id'];
        }else{
            $denuncia->fpr_id = null;
        }
*/
        $denuncia->save();
        return $denuncia->fresh();
    }

    public function getById($den_id):?Denuncia
    {
        $denuncia = Denuncia::find($den_id);
        $denuncia->estado_visto = 2;
        $denuncia->save();
        $denuncia->fresh();
        return $denuncia;

    }

    public function getAllPaginateBySearchAndSortACAndEl($limit,$searchtype,$search,$sort)
    {
        /*$sortCampo = $sort==1?'use.email':($sort==2?'pro.nombre_tienda':($sort==3?'prd.nombre_producto':'den.denuncia'));
        $where = array();
        $whereRaw = ' true ';
        if (!empty($search)){
            $campoSearch = $searchtype==1?'use.email':'pro.nombre_tienda';
            $whereRaw = " UPPER($campoSearch) like '%".strtoupper($search)."%' ";
        }

        return $this->denuncia->where($where)
            ->whereRaw($whereRaw)
            ->orderBy($sortCampo,'asc')
            ->paginate($limit);
        */

        return $this->denuncia->where([
        ])->orderBy('estado_visto','asc')->paginate($limit);

    }


 }
