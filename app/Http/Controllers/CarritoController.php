<?php

namespace App\Http\Controllers;

use App\Services\AuditoriaService;
use App\Services\CarritoService;
use App\Services\ProductoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Toastr;

class CarritoController extends Controller
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

    public function _agregarACarrito(Request $request)
    {
        try {
            if(Auth::check()){
                if ($request->has('prd_id')){
                    if (isset($request->prd_id)){
                        $producto = $this->productoService->getById($request->prd_id);
                        if (isset($producto)){
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
                                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'agregar al carrito',
                                'datos'=>json_encode($data)];
                            $this->auditoriaService->save($audi);

                            $cantidadActual = $this->carritoService->cantidadProductosMiCarrito($user->id);
                            if (isset($carritoSave)){
                                return response()->json([
                                    'res' => true,
                                    'mensaje' => 'Agregado al carrito',
                                    'cantidad' => $cantidadActual
                                ],200);
                            }else{
                                return response()->json([
                                    'res' => false,
                                    'mensaje' => 'No se pudo agregar al carrito'
                                ],200);
                            }
                        }else{
                            return response()->json([
                                'res' => false,
                                'mensaje' => 'No se pudo agregar al carrito'
                            ],200);
                        }
                    }else{
                        return response()->json([
                            'res' => false,
                            'mensaje' => 'No se pudo agregar al carrito'
                        ],200);
                    }
                }else{
                    return response()->json([
                        'res' => false,
                        'mensaje' => 'No se pudo agregar al carrito'
                    ],200);
                }

            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'Por favor. Ingrese al sistema para poder agregar productos a su carrito.'
                ],200);
            }
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo agregar al carrito'
            ],200);
        }
    }

    public function ver()
    {
        if(Auth::check()){
            $user = Auth::user();
            $carritos = $this->carritoService->getAllCarritoAc($user->id);
            return view('carrito.ver',compact('user','carritos'));
        }else{
            Toastr::warning('Por favor. Ingrese al sistema para ver su carrito de compras',"");
            return back()->withInput();
        }
    }

    public function quitarCarrito(Request $request)
    {
        if(Auth::check()){
            try {
                $user = Auth::user();
                $car_id = $request->car_id;
                $this->carritoService->quitarProductoCarrito($car_id);
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'car_carrito','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'quitar producto del carrito',
                    'datos'=>"car_id : $car_id"];
                $this->auditoriaService->save($audi);

                $cantidadActual = $this->carritoService->cantidadProductosMiCarrito($user->id);
                return response()->json([
                    'res' => true,
                    'mensaje' => 'Producto quitado',
                    'cantidad' => $cantidadActual
                ],200);
            }catch (\Exception $e){
                Log::error($e->getMessage(),$e->getTrace());
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo quitar el producto'
                ],200);
            }
        }else{
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo quitar el producto'
            ],200);
        }
    }

    public function quitarTodoCarrito(Request $request)
    {
        if(Auth::check()){
            try {
                $user = Auth::user();
                $this->carritoService->quitarTodosMisProductosCarrito($user->id);
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'car_carrito','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'quitar todos los productos del carrito',
                    'datos'=>"usr_id : $user->id"];
                $this->auditoriaService->save($audi);

                return response()->json([
                    'res' => true,
                    'mensaje' => 'Productos quitados'
                ],200);
            }catch (\Exception $e){
                Log::error($e->getMessage(),$e->getTrace());
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo quitar los productos'
                ],200);
            }
        }else{
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo quitar los productos'
            ],200);
        }
    }

}
