<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dto\ComunDto;
use App\Models\Dto\ErrorDto;
use App\Services\AuditoriaService;
use App\Services\CarritoService;
use App\Services\ProductoService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CarritoControllerApi extends Controller
{
    protected $carritoService;
    protected $productoService;
    protected $auditoriaService;
    public function __construct(
        CarritoService $carritoService,
        ProductoService $productoService,
        AuditoriaService $auditoriaService
    )
    {
        $this->carritoService = $carritoService;
        $this->productoService = $productoService;
        $this->auditoriaService = $auditoriaService;
    }

    public function agregarACarrito(Request $request)
    {
        try {
            if ($request->has('prdId')){
                if (isset($request->prdId)){
                    $producto = $this->productoService->getById($request->prdId);
                    $user = Auth::user();
                    $data = array();
                    $data['cantidad'] = 1;
                    if ($request->has('cantidad')){
                        if (isset($request->cantidad)){
                            $data['cantidad'] = $request->cantidad;
                        }
                    }
                    $data['precio_venta'] = $producto->precio;
                    $data['fecha'] = date('Y-m-d H:i:s');
                    $data['precio_base_delivery'] = 0;
                    $data['estado'] = 'AC';
                    $data['prd_id'] = $producto->prd_id;
                    $data['usr_id'] = $user->id;
                    $carritoSave = $this->carritoService->save($data);
                    //logs
                    $audi = ['ip'=>$request->ip(),'tabla'=>'car_carrito','usuario'=>$user->id.'-'.$user->name,
                        'fecha'=>date('Y-m-d H:i:s'),'accion'=>'APP agregar al carrito',
                        'datos'=>json_encode($data)];
                    $this->auditoriaService->save($audi);

                    if (isset($carritoSave)){
                        return response()->json([
                            'res' => true,
                            'mensaje' => 'Agregado al carrito'
                        ],200);
                    }else{
                        return response()->json([
                            'res' => false,
                            'mensaje' => 'No se pudo agregar al carrito'
                        ],400);
                    }
                }else{
                    return response()->json([
                        'res' => false,
                        'mensaje' => 'No se pudo agregar al carrito'
                    ],400);
                }
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo agregar al carrito'
                ],400);
            }
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function quitarCarrito(Request $request)
    {
        try {
            $user = Auth::user();
            $car_id = $request->carId;
            $this->carritoService->quitarProductoCarrito($car_id);
            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'car_carrito','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'APP quitar producto del carrito',
                'datos'=>" car_id: $car_id "];
            $this->auditoriaService->save($audi);

            return response()->json([
                'res' => true,
                'mensaje' => 'Producto quitado del Carrito'
            ],200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function miCarrito()
    {
        try {
            $user = Auth::user();
            $carritos = $this->carritoService->getAllCarritoAc($user->id);
            $lista = new Collection();
            foreach ($carritos as $k=>$carrito){
                $carri = new ComunDto();
                $carri->carId = $carrito->car_id;
                $imagen = '';
                foreach ($carrito->producto->imagenesProducto as $k=>$ima){
                    if ($ima->estado == 'AC' && $ima->tipo == 12){
                        $imagen = asset('storage/uploads/'.$ima->imagen);
                        break;
                    }
                }
                $carri->imagen = $imagen;
                $carri->prdId = $carrito->prd_id;
                $carri->producto = $carrito->producto->nombre_producto;
                $carri->precio = $carrito->precio_venta;
                $carri->cantidad = $carrito->cantidad;
                $carri->total = round(($carrito->cantidad * $carrito->precio_venta),2);
                $lista->push($carri);
            }
            return response()->json($lista->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

}
