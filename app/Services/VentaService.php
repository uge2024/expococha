<?php


namespace App\Services;


use App\Repositories\VentaRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VentaService
{
    protected $ventaRepository;
    public function __construct(VentaRepository $ventaRepository)
    {
        $this->ventaRepository = $ventaRepository;
    }

    public function save($data)
    {
        try {
            return $this->ventaRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function updateEstadoDelivery($ven_id,$estado_delivery)
    {
        try {
            return $this->ventaRepository->updateEstadoDelivery($ven_id,$estado_delivery);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function updateEstadoVenta($ven_id,$estado_venta)
    {
        try {
            return $this->ventaRepository->updateEstadoVenta($ven_id,$estado_venta);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function getById($ven_id)
    {
        return $this->ventaRepository->getById($ven_id);
    }

    public function getAll()
    {
        return $this->ventaRepository->getAll();
    }

    public function getAllByPaginateAndSearchAndSort($limit,$searchtype,$search,$sort)
    {
        return $this->ventaRepository->getAllByPaginateAndSearchAndSort($limit,$searchtype,$search,$sort);
    }

    public function getAllVentasByUsrIdAndPaginateAndSortByFecha($usr_id,$limit)
    {
        return $this->ventaRepository->getAllVentasByUsrIdAndPaginateAndSortByFecha($usr_id,$limit);
    }

    public function marcarVentaComoConfirmada($ven_id,$estado_venta,$estado_delivery)
    {
        DB::beginTransaction();
        try {
            $venta = $this->ventaRepository->marcarVentaComoConfirmada($ven_id,$estado_venta,$estado_delivery);
            DB::commit();
            return $venta;
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    public function getAllVentasByProIdAndPaginateAndSortByFecha($pro_id,$limit,$searchtype,$search,$sort)
    {
        return $this->ventaRepository->getAllVentasByProIdAndPaginateAndSortByFecha($pro_id,$limit,$searchtype,$search,$sort);
    }

    public function updateDeliveryAndTotal($ven_id,$del_id,$precio_base_delivery,$subtotal)
    {
        return $this->ventaRepository->updateDeliveryAndTotal($ven_id,$del_id,$precio_base_delivery,$subtotal);
    }

    public function getAllVentasPaginateAndSearchAndSort($limit,$searchtype,$search,$sort)
    {
        return $this->ventaRepository->getAllVentasPaginateAndSearchAndSort($limit,$searchtype,$search,$sort);
    }

}
