<?php


namespace App\Repositories;


use App\Models\ValoracionProducto;

class ValoracionProductoRepository
{
    protected $valoracionProducto;
    public function __construct(ValoracionProducto $valoracionProducto)
    {
        $this->valoracionProducto = $valoracionProducto;
    }

    public function save($data):?ValoracionProducto
    {
        $valoracionProducto = new $this->valoracionProducto;
        $valoracionProducto->prd_id = $data['prd_id'];
        $valoracionProducto->usr_id = $data['usr_id'];
        $valoracionProducto->puntuacion = $data['puntuacion'];
        $valoracionProducto->valoracion = $data['valoracion'];
        $valoracionProducto->fecha = $data['fecha'];
        $valoracionProducto->estado = $data['estado'];
        $valoracionProducto->save();
        return $valoracionProducto->fresh();
    }

    public function getValoracionesProductoByLimitSortByFechaDesc($prd_id,$limit)
    {
        return $this->valoracionProducto::where([
            ['prd_id','=',$prd_id],
            ['estado','=','AC']
        ])->orderBy('fecha','desc')->with(['producto','usuario'])->limit($limit)->get();
    }

}
