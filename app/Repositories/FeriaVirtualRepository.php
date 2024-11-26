<?php
namespace App\Repositories;
use App\Models\FeriaProducto;
use App\Models\FeriaVirtual;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FeriaVirtualRepository
{
    protected $feriaVirtual;
    public function __construct(FeriaVirtual $feriaVirtual)
    {
        $this->feriaVirtual = $feriaVirtual;
    }

    public function getAll(): Collection
    {
        return $this->feriaVirtual->all();
    }

    public function getAllPaginate($limit)
    {
        return $this->feriaVirtual->where([
        ])->orderBy('fecha_inicio','asc')->paginate($limit);
    }

    public function getAllByAc(): Collection
    {
        return $this->feriaVirtual->where([
            ['estado','=','AC']
        ])->orderBy('nombre','asc')->get();
    }

    public function getRubros(): Collection
    {
        return $this->feriaVirtual->all();
    }

    public function save($data):?FeriaVirtual
    {
        $feriaVirtual = new $this->feriaVirtual;
        $feriaVirtual->version = $data['version'];
        $feriaVirtual->nombre = $data['nombre'];
        $feriaVirtual->descripcion = $data['descripcion'];
        $feriaVirtual->fecha_inicio = $data['fecha_inicio'];
        $feriaVirtual->fecha_final = $data['fecha_final'];
        $feriaVirtual->lugar = $data['lugar'];
        $feriaVirtual->direccion = $data['direccion'];
        $feriaVirtual->estado = $data['estado'];
        $feriaVirtual->rub_id = $data['rub_id'];
        $feriaVirtual->longitud = $data['longitud'];
        $feriaVirtual->latitud = $data['latitud'];
        $feriaVirtual->save();
        return $feriaVirtual->fresh();
    }

    public function getById($fev_id):?FeriaVirtual
    {
        $feriaVirtual = FeriaVirtual::find($fev_id);
        return $feriaVirtual;

    }

    public function update($data):?FeriaVirtual
    {
        $feriaVirtual = FeriaVirtual::find($data['fev_id']);
        $feriaVirtual->version = $data['version'];
        $feriaVirtual->nombre = $data['nombre'];
        $feriaVirtual->descripcion = $data['descripcion'];
        $feriaVirtual->fecha_inicio = $data['fecha_inicio'];
        $feriaVirtual->fecha_final = $data['fecha_final'];
        $feriaVirtual->lugar = $data['lugar'];
        $feriaVirtual->direccion = $data['direccion'];
        $feriaVirtual->estado = $data['estado'];
        $feriaVirtual->rub_id = $data['rub_id'];
        $feriaVirtual->longitud = $data['longitud'];
        $feriaVirtual->latitud = $data['latitud'];
        $feriaVirtual->save();
        return $feriaVirtual->fresh();
    }

    public function delete($data,$texto):?FeriaVirtual
    {
        $feriaVirtual = FeriaVirtual::find($data['fev_id']);
        if($texto == 'inhabilitar') {
            $feriaVirtual->estado = 'EL';
            $feriaVirtual->save();
            return $feriaVirtual->fresh();
        }
        if($texto == 'habilitar'){
            $feriaVirtual->estado = 'AC';
            $feriaVirtual->save();
            return $feriaVirtual->fresh();
        }
    }

    public function getAllPaginateBySearchAndSortACAndEl($limit,$searchtype,$search,$sort)
    {
        $sortCampo = $sort==1?'fev.nombre':($sort==2?'fev.descripcion':($sort==3?'fev.lugar':'rub.nombre'));
        $where = array();
        $whereRaw = ' true ';
        if (!empty($search)){
            $campoSearch = $searchtype==1?'fev.nombre':'fev.descripcion';
            $whereRaw = " UPPER($campoSearch) like '%".strtoupper($search)."%' ";
        }
        return DB::table('fev_feria_virtual as fev')
            ->leftJoin('rub_rubro as rub','rub.rub_id','fev.rub_id')
            ->where($where)
            ->whereRaw($whereRaw)
            ->select('fev.fev_id as fev_id'
                            ,'fev.nombre as nombre'
                            ,'fev.descripcion as descripcion'
                            ,'fev.lugar as lugar'
                            ,'rub.nombre as rubro'
                            ,'fev.estado as estado'
                            ,'fev.fecha_inicio as fecha_inicio'
                            ,'fev.fecha_final as fecha_final')
            ->orderBy($sortCampo,'asc')
            ->paginate($limit);

    }

    public function getferiasHabilitadas()
    {
        $hoy  = date("Y-m-d");

        return $this->feriaVirtual->where([
            ['estado','=','AC'],
            ['fecha_inicio','>=',$hoy]
        ])->orderBy('nombre','asc')->get();

    }

    public function getAllAcAndPaginateAndSort($limit,$sort)
    {
        $campoSort = 'fecha_inicio';
        $orden = 'desc';
        if (isset($sort)){
            switch ($sort){
                case 1:
                    $campoSort = 'nombre';
                    $orden = 'asc';
                    break;
                case 2:
                    $campoSort = 'fecha_inicio';
                    $orden = 'asc';
                    break;
                case 3:
                    $campoSort = 'fecha_inicio';
                    $orden = 'desc';
                    break;
                default:
                    $campoSort = 'nombre';
                    $orden = 'asc';
            }
        }
        return $this->feriaVirtual->where([
            ['estado','=','AC']
        ])->orderBy($campoSort,$orden)->paginate($limit);
    }

    public function cargarferiasVirtualesComboHabilitado()
    {
        $hoy  = date("Y-m-d");
        return $this->feriaVirtual->where([
            ['fecha_final','>=',$hoy]
        ])->orderBy('nombre','asc')->pluck("nombre",'fev_id','listarubro')->prepend('Seleccione una Feria Virtual','0');

    }

    public function getFeriasByLimitAndOrden($inicio,$limit,$orden)
    {
        $campoSort = 'nombre';
        $maneraOrden = 'asc';
        switch ($orden){
            case 1://nombre
                $campoSort = 'nombre';
                $maneraOrden = 'asc';
                break;
            case 2://fecha
                $campoSort = 'fecha_inicio';
                $maneraOrden = 'desc';
                break;
            default:
                $campoSort = 'nombre';
                $maneraOrden = 'asc';
        }
        return $this->feriaVirtual->where([
            ['estado','=','AC']
        ])->orderBy($campoSort,$maneraOrden)->skip($inicio)->take($limit)->get();
    }

    /**
     * lista de productos de una feria virtual para la app
     * @param $fev_id
     * @param $inicio
     * @param $limit
     * @param $orden
     * @return mixed
     */
    public function getProductosFeriasByFeriaAndLimitAndOrden($fev_id,$inicio,$limit,$orden)
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
        return FeriaProducto::where([
            ['estado','=','AC']
        ])->whereHas('productor', function ($query){
            $query->where([
                ['estado_tienda', 'like', 'AC']
            ]);
        })->whereHas('feriaProductor', function ($query2) use($fev_id){
            $query2->where([
                ['estado', '=', 'AC'],
                ['fev_id','=',$fev_id]
            ]);
        })->orderBy($campoSort,$maneraOrden)
            ->with(['imagenesFeriaProductos'])->skip($inicio)->take($limit)->get();

    }

    /**
     * lista de todos los productos de una feria para la pagina
     * @param $fev_id
     * @param $inicio
     * @param $limit
     * @param $orden
     * @return mixed
     */
    public function getAllProductosFeriasAcAndTiendaAcByFeriaAndOrden($fev_id)
    {
        return FeriaProducto::where([
            ['estado','=','AC']
        ])->whereHas('productor', function ($query){
            $query->where([
                ['estado_tienda', 'like', 'AC']
            ]);
        })->whereHas('feriaProductor', function ($query2) use($fev_id){
            $query2->where([
                ['estado', '=', 'AC'],
                ['fev_id','=',$fev_id]
            ]);
        })->orderBy('nombre_producto','asc')
            ->with(['imagenesFeriaProductos'])->get();

    }

}
