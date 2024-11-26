<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dto\ComunDto;
use App\Models\Dto\ErrorDto;
use App\Models\Dto\VentaDto;
use App\Services\AuditoriaService;
use App\Services\FeriaProductoService;
use App\Services\ParametricaService;
use App\Services\ProductorService;
use App\Services\ProductoService;
use App\Services\UserService;
use App\Services\VentaService;
use App\Utils\EnviarCorreosStock;
use App\Utils\EnviarCorreosVentas;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;

class VentaControllerApi extends Controller
{
    protected $ventaService;
    protected $productoService;
    protected $productorService;
    protected $feriaProductoService;
    protected $parametricaService;
    protected $userService;
    protected $auditoriaService;
    public function __construct(
        VentaService $ventaService,
        ProductoService $productoService,
        ProductorService $productorService,
        ParametricaService $parametricaService,
        FeriaProductoService $feriaProductoService,
        UserService $userService,
        AuditoriaService $auditoriaService
    )
    {
        $this->ventaService = $ventaService;
        $this->productoService = $productoService;
        $this->productorService = $productorService;
        $this->parametricaService = $parametricaService;
        $this->feriaProductoService = $feriaProductoService;
        $this->userService = $userService;
        $this->auditoriaService = $auditoriaService;
    }

    public function miscompras()
    {
        try {
            $user = Auth::user();
            $tipo_pagos = array(1=>'QR',2=>'Deposito',3=>'Efectivo');
            $estado_ventas = array(1=>'Por Confirmar',2=>'No Concretizada',3=>'Concretizada');
            $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
            $ventas = $this->ventaService->getAllVentasByUsrIdAndPaginateAndSortByFecha($user->id,1000);
            $lista = new Collection();
            foreach ($ventas as $key=>$venta){
                $ven = new VentaDto();
                $ven->venId = $venta->ven_id;
                $ven->esProductoFeria = false;
                $ven->delId = $venta->del_id;
                $ven->delivery = $venta->delivery->razon_social;
                $ven->estadoDelivery = $estado_deliverys[$venta->estado_delivery];
                $ven->prdId = $venta->prd_id;
                $ven->fprId = $venta->fpr_id;
                $ven->estadoVenta = $estado_ventas[$venta->estado_venta];
                $ven->tipoPago = $tipo_pagos[$venta->tipo_pago];
                $ven->fecha = $venta->fecha;
                $ven->comprobante = $venta->comprobante;
                $ven->producto = '';
                $ven->cantidad = $venta->cantidad;
                $ven->precioVenta = $venta->precio_venta;
                $ven->precioBaseDelivery = $venta->precio_base_delivery;
                $ven->subtotal = $venta->subtotal;
                if (isset($venta->fpr_id)){
                    $ven->esProductoFeria = true;
                    $ven->producto = $venta->feriaProducto->nombre_producto;
                    $imagen = '';
                    foreach ($venta->feriaProducto->imagenesFeriaProductos as $ima){
                        if ($ima->estado == 'AC' && $ima->tipo == 12){
                            $imagen = asset('storage/uploads/'.$ima->imagen);
                            break;
                        }
                    }
                    $ven->imagen = $imagen;
                }
                if (isset($venta->prd_id)){
                    $ven->esProductoFeria = false;
                    $ven->producto = $venta->producto->nombre_producto;
                    $imagen = '';
                    foreach ($venta->producto->imagenesProducto as $ima){
                        if ($ima->estado == 'AC' && $ima->tipo == 12){
                            $imagen = asset('storage/uploads/'.$ima->imagen);
                            break;
                        }
                    }
                    $ven->imagen = $imagen;
                }
                $lista->push($ven);

            }
            return response()->json($lista->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    /**
     * guarda una venta realizada por redes sociales
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $data = array();
            $data['usr_id'] = $user->id;
            $delivery = null;
            $esProductoFeria = false;
            if ($request->has('prdId')){
                $data['prd_id'] = $request->prdId;
                $producto = $this->productoService->getById($request->prdId);
                $productor = $producto->productor;
                $delivery = $productor->deliverys->first(function ($value, $key) {
                    return $value->estado == 'AC';
                });
            }
            if ($request->has('fprId')){
                $data['fpr_id'] = $request->fprId;
                $productoFeria = $this->feriaProductoService->getById($request->fprId);
                $productor = $productoFeria->productor;
                $delivery = $productor->deliverys->first(function ($value, $key) {
                    return $value->estado == 'AC';
                });
                $esProductoFeria = true;
            }
            $tipo_pagos = array(1=>'QR',2=>'Deposito',3=>'Efectivo');
            $data['tipo_pago'] = 3;
            $estado_ventas = array(1=>'Por Confirmar',2=>'No Concretizada',3=>'Concretizada');
            $data['estado_venta'] = 1;//por confirmar
            $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
            $data['estado_delivery'] = 1;//en proceso
            $data['estado'] = 'AC';
            $cantidad = $request->cantidad;
            $precio_venta = $request->precioVenta;
            if (empty($delivery)){
                $error = new ErrorDto();
                $error->codigo = 500;
                $error->error = 'No se pudo completar la venta';
                return response()->json($error->toArray(),400);
            }
            $data['del_id'] = $delivery->del_id;
            $precio_base_delivery = empty($delivery->costo_minimo)?0:$delivery->costo_minimo;
            $subtotal = ($cantidad * $precio_venta) + $precio_base_delivery;
            $subtotal = round($subtotal,2);
            $data['cantidad'] = $cantidad;
            $data['precio_venta'] = $precio_venta;
            $data['subtotal'] = $subtotal;
            $data['precio_base_delivery'] = $precio_base_delivery;
            $data['fecha'] = date('Y-m-d H:i:s');
            $data['comprobante'] = null;
            $venta = $this->ventaService->save($data);

            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'ven_venta','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'APP registro de venta',
                'datos'=>json_encode($data)];
            $this->auditoriaService->save($audi);

            if (!empty($venta)){
                if (!$esProductoFeria){
                    $envioCorreo = $this->enviarNotificacionVentaProducto($request->prdId,$request->cantidad,$request->precioVenta,'Efectivo');
                }else{
                    $envioCorreo = $this->enviarNotificacionVentaProductoFeria($request->fprId,$request->cantidad,$request->precioVenta,'Efectivo');
                }
                return response()->json([
                    'res' => true,
                    'mensaje' => 'Venta completada'
                ],200);
            }else{
                $error = new ErrorDto();
                $error->codigo = 500;
                $error->error = 'No se pudo completar la venta';
                return response()->json($error->toArray(),400);
            }
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    /**
     * guarda una venta realizada por codigo qr
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeqr(Request $request)
    {
        //Log::info($request->all());
        //Log::info($request->headers->all());
        try {
            $user = Auth::user();
            $data = array();
            $data['usr_id'] = $user->id;
            $delivery = null;
            $esProductoFeria = false;
            if ($request->has('prdId')){
                $data['prd_id'] = $request->prdId;
                $producto = $this->productoService->getById($request->prdId);
                $productor = $producto->productor;
                $delivery = $productor->deliverys->first(function ($value, $key) {
                    return $value->estado == 'AC';
                });
            }
            if ($request->has('fprId')){
                $data['fpr_id'] = $request->fprId;
                $productoFeria = $this->feriaProductoService->getById($request->fprId);
                $productor = $productoFeria->productor;
                $delivery = $productor->deliverys->first(function ($value, $key) {
                    return $value->estado == 'AC';
                });
                $esProductoFeria = true;
            }
            $tipo_pagos = array(1=>'QR',2=>'Deposito',3=>'Efectivo');
            $data['tipo_pago'] = 1;
            $estado_ventas = array(1=>'Por Confirmar',2=>'No Concretizada',3=>'Concretizada');
            $data['estado_venta'] = 1;//por confirmar
            $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
            $data['estado_delivery'] = 1;//en proceso
            $data['estado'] = 'AC';
            $cantidad = $request->cantidad;
            $precio_venta = $request->precioVenta;
            if (empty($delivery)){
                $error = new ErrorDto();
                $error->codigo = 500;
                $error->error = 'No se pudo completar la venta, no hay delivery para el prdId '.$request->prdId;
                return response()->json($error->toArray(),400);
            }
            $data['del_id'] = $delivery->del_id;
            $precio_base_delivery = empty($delivery->costo_minimo)?0:$delivery->costo_minimo;
            $subtotal = ($cantidad * $precio_venta) + $precio_base_delivery;
            $subtotal = round($subtotal,2);
            $data['cantidad'] = $cantidad;
            $data['precio_venta'] = $precio_venta;
            $data['subtotal'] = $subtotal;
            $data['precio_base_delivery'] = $precio_base_delivery;
            $data['fecha'] = date('Y-m-d H:i:s');


            $data['comprobante'] = null;
            if ($request->hasFile('comprobante')) {

                $tamanio = $this->parametricaService->getParametricaByTipoAndCodigo('TIPO-IMAGEN-20');
                $ruta = storage_path('app/public/uploads/');
                $files = $request->file('comprobante');
                //dd($files,is_array($files));
                if (is_array($files)){
                    $messages = [
                        'comprobante' => 'Debe de seleccionar una imagen jpg'
                    ];
                    $validator = Validator::make($request->all(), [
                        'comprobante.*' => 'mimes:jpeg,jpg,JPEG,JPG,PNG,png|max:2000'
                    ], $messages);

                    if ($validator->fails()) {
                        $error = new ErrorDto();
                        $error->codigo = 500;
                        $error->error = 'No se pudo completar la venta, los comprobantes no son validos';
                        return response()->json($error->toArray(),400);
                    }
                    foreach ($files as $file){
                        $extencionImagen = $file->extension();
                        $nombre = 'comp'.time() . '' . uniqid() . '.' . $extencionImagen;
                        $data['comprobante'] = $nombre;
                        $imagen = Image::make($file);
                        $imagen->resize($tamanio->valor2, $tamanio->valor3);
                        $imagen->save($ruta . $nombre, 95);
                        break;
                    }
                }else{
                    $file = $files;
                    $messages = [
                        'comprobante' => 'Debe de seleccionar una imagen jpg'
                    ];
                    $validator = Validator::make($request->all(), [
                        'comprobante' => 'mimes:jpeg,jpg,JPEG,JPG,PNG,png|max:2000'
                    ], $messages);

                    if ($validator->fails()) {
                        $error = new ErrorDto();
                        $error->codigo = 500;
                        $error->error = 'No se pudo completar la venta, el comprobante no es valido';
                        return response()->json($error->toArray(),400);
                    }

                    $extencionImagen = $file->extension();
                    $nombre = 'comp'.time() . '' . uniqid() . '.' . $extencionImagen;
                    $data['comprobante'] = $nombre;
                    $imagen = Image::make($file);
                    $imagen->resize($tamanio->valor2, $tamanio->valor3);
                    $imagen->save($ruta . $nombre, 95);
                }

            }

            $venta = $this->ventaService->save($data);

            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'ven_venta','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'APP registro de venta QR',
                'datos'=>json_encode($data)];
            $this->auditoriaService->save($audi);

            if (!empty($venta)){
                if (!$esProductoFeria){
                    $envioCorreo = $this->enviarNotificacionVentaProducto($request->prdId,$request->cantidad,$request->precioVenta,'QR');
                }else{
                    $envioCorreo = $this->enviarNotificacionVentaProductoFeria($request->fprId,$request->cantidad,$request->precioVenta,'QR');
                }
                return response()->json([
                    'res' => true,
                    'mensaje' => 'Venta completada'
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo completar la venta'
                ]);
            }
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    /**
     * guarda una venta realizada por deposito
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storedeposito(Request $request)
    {
        try {
            $user = Auth::user();
            $data = array();
            $data['usr_id'] = $user->id;
            $delivery = null;
            $esProductoFeria = false;
            if ($request->has('prdId')){
                $data['prd_id'] = $request->prdId;
                $producto = $this->productoService->getById($request->prdId);
                $productor = $producto->productor;
                $delivery = $productor->deliverys->first(function ($value, $key) {
                    return $value->estado == 'AC';
                });
            }
            if ($request->has('fprId')){
                $data['fpr_id'] = $request->fprId;
                $productoFeria = $this->feriaProductoService->getById($request->fprId);
                $productor = $productoFeria->productor;
                $delivery = $productor->deliverys->first(function ($value, $key) {
                    return $value->estado == 'AC';
                });
                $esProductoFeria = true;
            }
            $tipo_pagos = array(1=>'QR',2=>'Deposito',3=>'Efectivo');
            $data['tipo_pago'] = 2;
            $estado_ventas = array(1=>'Por Confirmar',2=>'No Concretizada',3=>'Concretizada');
            $data['estado_venta'] = 1;//por confirmar
            $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
            $data['estado_delivery'] = 1;//en proceso
            $data['estado'] = 'AC';
            $cantidad = $request->cantidad;
            $precio_venta = $request->precioVenta;
            if (empty($delivery)){
                $error = new ErrorDto();
                $error->codigo = 500;
                $error->error = 'No se pudo completar la venta';
                return response()->json($error->toArray(),400);
            }
            $data['del_id'] = $delivery->del_id;
            $precio_base_delivery = empty($delivery->costo_minimo)?0:$delivery->costo_minimo;
            $subtotal = ($cantidad * $precio_venta) + $precio_base_delivery;
            $subtotal = round($subtotal,2);
            $data['cantidad'] = $cantidad;
            $data['precio_venta'] = $precio_venta;
            $data['subtotal'] = $subtotal;
            $data['precio_base_delivery'] = $precio_base_delivery;
            $data['fecha'] = date('Y-m-d H:i:s');


            $data['comprobante'] = null;
            if ($request->hasFile('comprobante')) {

                $tamanio = $this->parametricaService->getParametricaByTipoAndCodigo('TIPO-IMAGEN-20');
                $ruta = storage_path('app/public/uploads/');
                $files = $request->file('comprobante');
                //dd($files,is_array($files));
                if (is_array($files)){
                    $messages = [
                        'comprobante' => 'Debe de seleccionar una imagen jpg'
                    ];
                    $validator = Validator::make($request->all(), [
                        'comprobante.*' => 'mimes:jpeg,jpg,JPEG,JPG,PNG,png|max:2000'
                    ], $messages);

                    if ($validator->fails()) {
                        $error = new ErrorDto();
                        $error->codigo = 500;
                        $error->error = 'No se pudo completar la venta, los comprobantes no son validos';
                        return response()->json($error->toArray(),400);
                    }
                    foreach ($files as $file){
                        $extencionImagen = $file->extension();
                        $nombre = 'comp'.time() . '' . uniqid() . '.' . $extencionImagen;
                        $data['comprobante'] = $nombre;
                        $imagen = Image::make($file);
                        $imagen->resize($tamanio->valor2, $tamanio->valor3);
                        $imagen->save($ruta . $nombre, 95);
                        break;
                    }
                }else{
                    $file = $files;
                    $messages = [
                        'comprobante' => 'Debe de seleccionar una imagen jpg'
                    ];
                    $validator = Validator::make($request->all(), [
                        'comprobante' => 'mimes:jpeg,jpg,JPEG,JPG,PNG,png|max:2000'
                    ], $messages);

                    if ($validator->fails()) {
                        $error = new ErrorDto();
                        $error->codigo = 500;
                        $error->error = 'No se pudo completar la venta, el comprobante no es valido';
                        return response()->json($error->toArray(),400);
                    }

                    $extencionImagen = $file->extension();
                    $nombre = 'comp'.time() . '' . uniqid() . '.' . $extencionImagen;
                    $data['comprobante'] = $nombre;
                    $imagen = Image::make($file);
                    $imagen->resize($tamanio->valor2, $tamanio->valor3);
                    $imagen->save($ruta . $nombre, 95);
                }

            }

            $venta = $this->ventaService->save($data);

            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'ven_venta','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'APP registro de venta Deposito',
                'datos'=>json_encode($data)];
            $this->auditoriaService->save($audi);

            if (!empty($venta)){
                if (!$esProductoFeria){
                    $envioCorreo = $this->enviarNotificacionVentaProducto($request->prdId,$request->cantidad,$request->precioVenta,'Deposito');
                }else{
                    $envioCorreo = $this->enviarNotificacionVentaProductoFeria($request->fprId,$request->cantidad,$request->precioVenta,'Deposito');
                }
                return response()->json([
                    'res' => true,
                    'mensaje' => 'Venta completada'
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo completar la venta'
                ]);
            }
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }


    //notificacion de venta para el productor y el administrador de los productos
    private function enviarNotificacionVentaProducto($prd_id,$cantidad,$precio_venta,$literal_tipo_pago)
    {
        $producto = $this->productoService->getById($prd_id);
        $productor = $producto->productor;
        $usuario = $this->userService->getUser($productor->usr_id);
        $usuariosAdministradores = $this->userService->getAllUsersAdministradoresAc();
        $correos = array();
        foreach ($usuariosAdministradores as $key=>$user){
            array_push($correos,$user->email);
        }
        $notificacion = new EnviarCorreosVentas();
        $asunto = 'Venta de Productos';
        $mensaje = "Se registro una venta de tu tienda: <b>$productor->nombre_tienda</b> <br>";
        $mensaje .= "<p><b>Producto: </b> $producto->nombre_producto</p><br>";
        $mensaje .= "<p><b>Cantidad: </b> $cantidad</p><br>";
        $mensaje .= "<p><b>Tipo de pago: </b> $literal_tipo_pago</p><br>";
        $mensaje .= "<p>Por favor atiende esta venta.</p><br>";
        $res = $notificacion->enviarCorreosFerias($usuario,$asunto,$mensaje,$correos);
        return $res;
    }

    //notificacion de venta para el productor y el administrador de los productos de ferias
    private function enviarNotificacionVentaProductoFeria($fpr_id,$cantidad,$precio_venta,$literal_tipo_pago)
    {
        $producto = $this->feriaProductoService->getById($fpr_id);
        $productor = $producto->productor;
        $usuario = $this->userService->getUser($productor->usr_id);
        $usuariosAdministradores = $this->userService->getAllUsersAdministradoresAc();
        $correos = array();
        foreach ($usuariosAdministradores as $key=>$user){
            array_push($correos,$user->email);
        }
        $notificacion = new EnviarCorreosVentas();
        $asunto = 'Venta de Productos';
        $mensaje = "Se registro una venta de tu tienda: <b>$productor->nombre_tienda</b> <br>";
        $mensaje .= "<p><b>Producto: </b> $producto->nombre_producto</p><br>";
        $mensaje .= "<p><b>Cantidad: </b> $cantidad</p><br>";
        $mensaje .= "<p><b>Tipo de pago: </b> $literal_tipo_pago</p><br>";
        $mensaje .= "<p>Por favor atiende esta venta.</p><br>";
        $res = $notificacion->enviarCorreosFerias($usuario,$asunto,$mensaje,$correos);
        return $res;
    }


    public function estadoDelivery($ven_id)
    {
        try {
            $user = Auth::user();
            $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
            $venta = $this->ventaService->getById($ven_id);
            $comun = new ComunDto();
            $producto = null;
            if (isset($venta->prd_id)){
                $producto = $venta->producto;
            }elseif (isset($venta->fpr_id)){
                $producto = $venta->feriaProducto;
            }
            $comun->producto = $producto->nombre_producto;
            $comun->cantidad = $venta->cantidad;
            $comun->precioVenta = $venta->precio_venta;
            $comun->precioDelivery = $venta->precio_base_delivery;
            $comun->total = $venta->subtotal;
            $comun->estadoDelivery = $estado_deliverys[$venta->estado_delivery];
            $comun->delivery = $venta->delivery->razon_social;
            return response()->json($comun->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function marcarEntregado(Request $request){
        try {
            $user = Auth::user();
            //marcamos la venta como Concretizada y marcamos el delivery como Entregado y restamos productos del stock
            $ventaConfirmada = $this->ventaService->marcarVentaComoConfirmada($request->venId,3,3);

            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'ven_venta','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'APP venta marcada como confirmada',
                'datos'=>" ven_id: $request->venId "];
            $this->auditoriaService->save($audi);

            if (!empty($ventaConfirmada)){
                $estadoStock = $this->revisarEstadoStockProductoByVenta($request->ven_id);
                return response()->json([
                    'res' => true,
                    'mensaje' => 'Compra marcada como Entregada'
                ],200);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo confirmar la Entrega de la compra'
                ],400);
            }
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    //FUNCION PARA REVISAR EL ESTADO DEL STOCK
    private  function revisarEstadoStockProductoByVenta($ven_id){
        $res = true;
        try {
            $venta = $this->ventaService->getById($ven_id);
            if (isset($venta->prd_id)){
                $producto = $this->productoService->getById($venta->prd_id);
                if ($producto->existencia <= $producto->existencia_minima){
                    $productor = $producto->productor;
                    $usuario = $this->userService->getUser($productor->usr_id);
                    $asunto = 'Producto Con Bajo Stock';
                    $mensaje = "Se registro que un producto esta por acabarse en tu tienda: <b>$productor->nombre_tienda</b> <br>";
                    $mensaje .= "<p><b>Producto: </b> $producto->nombre_producto</p><br>";
                    $mensaje .= "<p><b>Existencia: </b> $producto->existencia</p><br>";
                    $mensaje .= "<p>Por favor revisa el stock de este producto.</p><br>";
                    Log::info('se envia notificacion producto');
                    $notificationStock = new EnviarCorreosStock();
                    $resEnvio = $notificationStock->enviarCorreo($usuario,$asunto,$mensaje);
                }
            }
            if (isset($venta->fpr_id)){
                $producto = $this->feriaProductoService->getById($venta->fpr_id);
                if ($producto->existencia <= $producto->existencia_minima){
                    $productor = $producto->productor;
                    $usuario = $this->userService->getUser($productor->usr_id);
                    $asunto = 'Producto Con Bajo Stock';
                    $mensaje = "Se registro que un producto esta por acabarse en tu tienda: <b>$productor->nombre_tienda</b> <br>";
                    $mensaje .= "<p><b>Producto: </b> $producto->nombre_producto</p><br>";
                    $mensaje .= "<p><b>Existencia: </b> $producto->existencia</p><br>";
                    $mensaje .= "<p>Por favor revisa el stock de este producto.</p><br>";
                    Log::info('se envia notificacion producto feria');
                    $notificationStock = new EnviarCorreosStock();
                    $resEnvio = $notificationStock->enviarCorreo($usuario,$asunto,$mensaje);
                }
            }

        }catch (\Exception $e){
            $res = false;
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
        return $res;
    }
    //END FUNCION PARA REVISAR EL ESTADO DEL STOCK

}
