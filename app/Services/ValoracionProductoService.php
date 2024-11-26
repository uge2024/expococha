<?php


namespace App\Services;


use App\Repositories\ValoracionProductoRepository;
use Illuminate\Support\Facades\Log;

class ValoracionProductoService
{
    protected $valoracionProductoRepository;
    public function __construct(ValoracionProductoRepository $valoracionProductoRepository)
    {
        $this->valoracionProductoRepository = $valoracionProductoRepository;
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->valoracionProductoRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getValoracionesProductoByLimitSortByFechaDesc($prd_id,$limit)
    {
        return $this->valoracionProductoRepository->getValoracionesProductoByLimitSortByFechaDesc($prd_id,$limit);
    }

}
