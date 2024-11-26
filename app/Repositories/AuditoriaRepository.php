<?php


namespace App\Repositories;


use App\Models\Auditoria;

class AuditoriaRepository
{
    protected $auditoria;
    public function __construct(Auditoria $auditoria)
    {
        $this->auditoria = $auditoria;
    }

    public function save($data)
    {
        $dato = new $this->auditoria();
        $dato->ip = $data['ip'];
        $dato->tabla = $data['tabla'];
        $dato->usuario = $data['usuario'];
        $dato->fecha = $data['fecha'];
        $dato->accion = $data['accion'];
        $dato->datos = $data['datos'];
        $dato->save();
        return $dato->fresh();
    }

    public function getTodosPaginateBySearchAndSort($limit,$searchtype,$search,$sort,$fecha_inicio,$fecha_fin)
    {
        /*$campoSearch = $searchtype==1?'name':'email';
        $sortCampo = $sort==1?'name':($sort==2?'email':'rol');
        return $this->user->whereRaw(
            "UPPER($campoSearch) like '%".strtoupper($search)."%'"
        )->orderBy($sortCampo,'asc')->paginate($limit);*/
        $whereRaw = " true ";
        if (!empty($search)){
            if ($searchtype == 1){
                $whereRaw = " UPPER(usuario) like '%".strtoupper($search)."%' ";
            }elseif ($searchtype == 2){
                $whereRaw = " UPPER(tabla) like '%".strtoupper($search)."%' ";
            }elseif ($searchtype == 3){
                $whereRaw = " UPPER(accion) like '%".strtoupper($search)."%' ";
            }
        }

        $sortDirection = 'desc';
        $sortField = 'fecha';
        if ($sort == 1){
            $sortDirection = 'desc';
            $sortField = 'fecha';
        }elseif ($sort == 2){
            $sortDirection = 'asc';
            $sortField = 'usuario';
        }

        $fecha_inicio = date('Y-m-d 00:00:00',strtotime(str_replace('/','-',$fecha_inicio)));
        $fecha_fin = date('Y-m-d 23:59:59',strtotime(str_replace('/','-',$fecha_fin)));
        return $this->auditoria->whereRaw($whereRaw)
            ->where([
                ['fecha','>=',$fecha_inicio],
                ['fecha','<=',$fecha_fin]
            ])
            ->orderBy($sortField,$sortDirection)
            ->paginate($limit);
    }

    public function getTodosBySearchAndSort($searchtype,$search,$sort,$fecha_inicio,$fecha_fin)
    {
        $whereRaw = " true ";
        if (!empty($search)){
            if ($searchtype == 1){
                $whereRaw = " UPPER(usuario) like '%".strtoupper($search)."%' ";
            }elseif ($searchtype == 2){
                $whereRaw = " UPPER(tabla) like '%".strtoupper($search)."%' ";
            }elseif ($searchtype == 3){
                $whereRaw = " UPPER(accion) like '%".strtoupper($search)."%' ";
            }
        }

        $sortDirection = 'desc';
        $sortField = 'fecha';
        if ($sort == 1){
            $sortDirection = 'desc';
            $sortField = 'fecha';
        }elseif ($sort == 2){
            $sortDirection = 'asc';
            $sortField = 'usuario';
        }

        $fecha_inicio = date('Y-m-d 00:00:00',strtotime(str_replace('/','-',$fecha_inicio)));
        $fecha_fin = date('Y-m-d 23:59:59',strtotime(str_replace('/','-',$fecha_fin)));
        return $this->auditoria->whereRaw($whereRaw)
            ->where([
                ['fecha','>=',$fecha_inicio],
                ['fecha','<=',$fecha_fin]
            ])
            ->orderBy($sortField,$sortDirection)
            ->cursor();//se esta usando cursor ya que tratamos con miles de datos
            //->get();
    }

}
