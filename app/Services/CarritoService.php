<?php


namespace App\Services;


use App\Models\Carrito;
use App\Repositories\CarritoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarritoService
{
    protected $carritoRepository;
    public function __construct(CarritoRepository $carritoRepository)
    {
        $this->carritoRepository = $carritoRepository;
    }

    public function save($data):?Carrito
    {
        $result = null;
        try {
            $result = $this->carritoRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function quitarProductoCarrito($car_id)
    {
        $result = null;
        try {
            $result = $this->carritoRepository->quitarProductoCarrito($car_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function quitarTodosMisProductosCarrito($usr_id)
    {
        try {
            $this->carritoRepository->quitarTodosMisProductosCarrito($usr_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
    }

    public function getAllCarritoAc($usr_id)
    {
        return $this->carritoRepository->getAllCarritoAc($usr_id);
    }

    public function cantidadProductosMiCarrito($usr_id)
    {
        return $this->carritoRepository->cantidadProductosMiCarrito($usr_id);
    }

}
