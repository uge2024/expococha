<?php


namespace App\Repositories;
use App\Models\Asociacion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AsociacionRepository
{
    protected $asociacion;
    public function __construct(Asociacion $asociacion)
    {
        $this->asociacion = $asociacion;
    }

    public function getAll(): Collection
    {
        return $this->asociacion->where([
            ['estado', '=', 'AC']
        ])->orderBy('nombre', 'asc')->get();
    }

    public function save($data):?asociacion
    {
        $asociacion = new $this->asociacion;
        $asociacion->sigla = $data['sigla'];
        $asociacion->nombre = $data['nombre'];
        $asociacion->actividad = $data['actividad'];
        $asociacion->direccion = $data['direccion'];
        $asociacion->estado = $data['estado'];
        if (isset($data['telefono'])) {
            $asociacion->telefono = $data['telefono'];
        } else {
            $asociacion->telefono = null;
        }
        if (isset($data['celular'])) {
            $asociacion->celular = $data['celular'];
        } else {
            $asociacion->celular = null;
        }
        $asociacion->save();
        return $asociacion->fresh();
    }

    public function getById($aso_id):?Asociacion
    {
        $asociacion = Asociacion::find($aso_id);
        return $asociacion;

    }

    public function update($data):?Asociacion
    {
        $asociacion = Asociacion::find($data['aso_id']);
        $asociacion->sigla = $data['sigla'];
        $asociacion->nombre = $data['nombre'];
        $asociacion->actividad = $data['actividad'];
        $asociacion->direccion = $data['direccion'];
        $asociacion->estado = $data['estado'];
        if (isset($data['telefono'])) {
            $asociacion->telefono = $data['telefono'];
        } else {
            $asociacion->telefono = null;
        }
        if (isset($data['celular'])) {
            $asociacion->celular = $data['celular'];
        } else {
            $asociacion->celular = null;
        }
        $asociacion->save();
        return $asociacion->fresh();
    }

    public function delete($data): ?Asociacion
    {
        $asociacion = Asociacion::find($data['aso_id']);
        $asociacion->estado = 'EL';
        $asociacion->save();
        return $asociacion->fresh();
    }

    public function getAsociacionCombo()
    {
        $listaasociaciones = Asociacion::where([
            ['estado','not like','EL']
        ])->orderBy('nombre','asc')->orderBy('nombre','asc')->pluck("nombre",'aso_id','listaasociaciones');

        return $listaasociaciones;
    }
    public function getAllPaginate($limit)
    {
        return $this->asociacion->where([
            ['estado','=','AC']
        ])->orderBy('nombre','asc')->paginate($limit);
    }
    public function getAllPaginateBySearchAndSort($limit,$searchtype,$search,$sort)
    {
        $sortCampo = $sort==1?'aso.nombre':($sort==2?'aso.actividad':($sort==3?'aso.sigla':'aso.direccion'));
        $where = array();
        $whereRaw = ' true ';
        if (!empty($search)){
            $campoSearch = $searchtype==1?'aso.nombre':'aso.actividad';
            $whereRaw = " UPPER($campoSearch) like '%".strtoupper($search)."%' ";
        }
        return DB::table('aso_asociacion as aso')
            ->where($where)
            ->whereRaw($whereRaw)
            ->select('aso.aso_id as aso_id'
                ,'aso.sigla as sigla'
                ,'aso.nombre as nombre'
                ,'aso.actividad as actividad'
                ,'aso.direccion as direccion'
                ,'aso.celular'
                ,'aso.estado as estado')
            ->orderBy($sortCampo,'asc')
            ->paginate($limit);

    }


}
