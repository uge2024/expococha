<?php


namespace App\Repositories;


use App\Models\Backup;

class BackupRepository
{
    protected $backup;
    public function __construct(Backup $backup)
    {
        $this->backup = $backup;
    }

    public function save($data)
    {
        $dato = new $this->backup();
        $dato->ip = $data['ip'];
        $dato->usuario = $data['usuario'];
        $dato->fecha = $data['fecha'];
        $dato->archivo = $data['archivo'];
        $dato->save();
        return $dato->fresh();
    }

    public function getTodosPaginateBySearchAndSort($limit,$searchtype,$search,$sort,$fecha_inicio,$fecha_fin)
    {
        $whereRaw = " true ";
        if (!empty($search)){
            if ($searchtype == 1){
                $whereRaw = " UPPER(usuario) like '%".strtoupper($search)."%' ";
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
        return $this->backup->whereRaw($whereRaw)
            ->where([
                ['fecha','>=',$fecha_inicio],
                ['fecha','<=',$fecha_fin]
            ])
            ->orderBy($sortField,$sortDirection)
            ->paginate($limit);
    }

}
