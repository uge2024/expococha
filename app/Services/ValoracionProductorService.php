<?php


namespace App\Services;

use App\Repositories\ValoracionProductorRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ValoracionProductorService
{
    protected $valoracionProductorRepository;
    public function __construct(ValoracionProductorRepository $valoracionProductorRepository)
    {
        $this->valoracionProductorRepository = $valoracionProductorRepository;
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->valoracionProductorRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getValoracionesProductorByLimitSortByFechaDesc($pro_id,$limit)
    {
        return $this->valoracionProductorRepository->getValoracionesProductorByLimitSortByFechaDesc($pro_id,$limit);
    }

}
