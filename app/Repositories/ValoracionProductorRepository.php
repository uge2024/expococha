<?php


namespace App\Repositories;

use App\Models\ValoracionProductor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ValoracionProductorRepository
{
    protected $valoracionProductor;

    public function __construct(ValoracionProductor $valoracionProductor)
    {
        $this->valoracionProductor = $valoracionProductor;
    }

    public function save($data):?ValoracionProductor
    {
        $valoracionProductor = new $this->valoracionProductor;
        $valoracionProductor->pro_id = $data['pro_id'];
        $valoracionProductor->usr_id = $data['usr_id'];
        $valoracionProductor->puntuacion = $data['puntuacion'];
        $valoracionProductor->valoracion = $data['valoracion'];
        $valoracionProductor->fecha = $data['fecha'];
        $valoracionProductor->estado = $data['estado'];
        $valoracionProductor->save();
        return $valoracionProductor->fresh();
    }

    public function getValoracionesProductorByLimitSortByFechaDesc($pro_id,$limit)
    {
        return $this->valoracionProductor::where([
            ['pro_id','=',$pro_id],
            ['estado','=','AC']
        ])->orderBy('fecha','desc')->with(['productor','usuario'])->limit($limit)->get();
    }


}
