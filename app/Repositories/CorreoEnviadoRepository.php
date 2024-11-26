<?php


namespace App\Repositories;


use App\Models\CorreoEnviado;
use Illuminate\Support\Collection;

class CorreoEnviadoRepository
{

    protected $correoEnviado;
    public function __construct(CorreoEnviado $correoEnviado)
    {
        $this->correoEnviado = $correoEnviado;
    }

    public function getAllpaginate($limit)
    {
        return $this->correoEnviado->where([

        ])->orderBy('pro_id','asc')->paginate($limit);

    }

    public function save($correoEnviado):?CorreoEnviado
    {
        $correoEnviado = new $this->correoEnviado;
        $correoEnviado->enviado_a = $correoEnviado->enviado_a;
        $correoEnviado->enviado_por = $correoEnviado->enviado_por;
        $correoEnviado->asunto =$correoEnviado->asunto;
        $correoEnviado->descripcion = $correoEnviado->descripcion;
        $correoEnviado->pro_id = $correoEnviado->pro_id;
        $correoEnviado->estado = 'AC';
        $correoEnviado->save();
        return $correoEnviado->fresh();
    }
}
