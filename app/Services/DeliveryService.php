<?php

namespace App\Services;

use App\Repositories\DeliveryRepository;
use Illuminate\Support\Facades\Log;

class DeliveryService
{
    protected $deliveryRepository;
    public function __construct(DeliveryRepository $deliveryRepository)
    {
        $this->deliveryRepository = $deliveryRepository;
    }

    public function getAllPaginateDeliveryByProductor($limit,$pro_id)
    {
        return $this->deliveryRepository->getAllPaginateDeliveryByProductor($limit,$pro_id);
    }

    public function getAllPaginateDeliveryByProductorAC($limit,$pro_id)
    {
        return $this->deliveryRepository->getAllPaginateDeliveryByProductorAC($limit,$pro_id);
    }

    public function save($data)
    {
        $result = null;
        try {
            $result = $this->deliveryRepository->save($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }
    public function getById($cat_id)
    {
        $result = null;
        try {
            $result = $this->deliveryRepository->getById($cat_id);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;

    }

    public function update($data)
    {
        $result = null;
        try {
            $result = $this->deliveryRepository->update($data);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function delete($data,$texto)
    {
        $result = null;
        try {
            $result = $this->deliveryRepository->delete($data,$texto);
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
        }
        return $result;
    }

    public function getAllAcByProductor($pro_id)
    {
        return $this->deliveryRepository->getAllAcByProductor($pro_id);
    }
}
