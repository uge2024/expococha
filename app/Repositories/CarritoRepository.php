<?php


namespace App\Repositories;


use App\Models\Carrito;

class CarritoRepository
{
    protected $carrito;
    public function __construct(Carrito $carrito)
    {
        $this->carrito = $carrito;
    }

    public function save($data):?Carrito
    {
        $carrito = new $this->carrito;
        $carrito->cantidad = $data['cantidad'];
        $carrito->fecha = $data['fecha'];
        $carrito->estado = $data['estado'];
        $carrito->prd_id = $data['prd_id'];
        $carrito->usr_id = $data['usr_id'];
        if(isset($data['precio_venta'])){
            $carrito->precio_venta = $data['precio_venta'];
        }
        if(isset($data['precio_base_delivery'])){
            $carrito->precio_base_delivery = $data['precio_base_delivery'];
        }
        $carrito->save();
        return $carrito->fresh();
    }

    public function quitarProductoCarrito($car_id)
    {
        $carrito = $this->carrito->find($car_id);
        $carrito->estado = 'EL';
        $carrito->save();
        return $carrito->fresh();
    }

    public function quitarTodosMisProductosCarrito($usr_id)
    {
        $this->carrito->where([
            ['usr_id','=',$usr_id],
            ['estado','=','AC']
        ])->update(['estado'=>'EL']);
    }

    public function getAllCarritoAc($usr_id)
    {
        return $this->carrito->where([
            ['estado','=','AC'],
            ['usr_id','=',$usr_id]
        ])->orderBy('fecha','desc')->get();
    }

    public function cantidadProductosMiCarrito($usr_id)
    {
        return $this->carrito->where([
            ['estado','=','AC'],
            ['usr_id','=',$usr_id]
        ])->count();
    }

}
