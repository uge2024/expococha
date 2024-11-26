<?php

namespace App\Http\Controllers;

use App\Services\AuditoriaService;
use App\Services\DeliveryService;
use App\Services\FeriaProductoService;
use App\Services\ParametricaService;
use App\Services\ProductorService;
use App\Services\ProductoService;
use App\Services\UserService;
use App\Services\VentaService;
use App\Utils\EnviarCorreosStock;
use App\Utils\EnviarCorreosVentas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Toastr;

class VentaController extends Controller
{
    protected $deliveryService;
    protected $ventaService;
    protected $productoService;
    protected $productorService;
    protected $feriaProductoService;
    protected $parametricaService;
    protected $userService;
    protected $auditoriaService;
    public function __construct(
        DeliveryService $deliveryService,
        VentaService $ventaService,
        ProductoService $productoService,
        ProductorService $productorService,
        ParametricaService $parametricaService,
        FeriaProductoService $feriaProductoService,
        UserService $userService,
        AuditoriaService $auditoriaService
    )
    {
        $this->deliveryService = $deliveryService;
        $this->ventaService = $ventaService;
        $this->productoService = $productoService;
        $this->productorService = $productorService;
        $this->parametricaService = $parametricaService;
        $this->feriaProductoService = $feriaProductoService;
        $this->userService = $userService;
        $this->auditoriaService = $auditoriaService;
        $this->middleware('auth');
    }

    //GUARDADO DE LA VENTA
    public function _store(Request $request){
        try {
            $user = Auth::user();
            $data = array();
            $data['usr_id'] = $user->id;
            $delivery = null;
            $esProductoFeria = false;
            if ($request->has('prd_id')){
                $data['prd_id'] = $request->prd_id;
                $producto = $this->productoService->getById($request->prd_id);
                $productor = $producto->productor;
                $delivery = $productor->deliverys->first(function ($value, $key) {
                    return $value->estado == 'AC';
                });
            }
            if ($request->has('fpr_id')){
                $data['fpr_id'] = $request->fpr_id;
                $productoFeria = $this->feriaProductoService->getById($request->fpr_id);
                $productor = $productoFeria->productor;
                $delivery = $productor->deliverys->first(function ($value, $key) {
                    return $value->estado == 'AC';
                });
                $esProductoFeria = true;
            }
            $tipo_pagos = array(1=>'QR',2=>'Deposito',3=>'Efectivo');
            $data['tipo_pago'] = $request->tipo_pago;
            $estado_ventas = array(1=>'Por Confirmar',2=>'No Concretizada',3=>'Concretizada');
            $data['estado_venta'] = 1;//por confirmar
            $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
            $data['estado_delivery'] = 1;//en proceso
            $data['estado'] = 'AC';
            $cantidad = $request->cantidad;
            $precio_venta = $request->precio_venta;
            if (empty($delivery)){
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo completar la venta'
                ]);
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
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'registro de venta',
                'datos'=>json_encode($data)];
            $this->auditoriaService->save($audi);

            if (!empty($venta)){
                if (!$esProductoFeria){
                    //$envioCorreo = $this->enviarNotificacionVentaProducto($request->prd_id,$request->cantidad,$request->precio_venta,'Efectivo');
                }else{
                    //$envioCorreo = $this->enviarNotificacionVentaProductoFeria($request->fpr_id,$request->cantidad,$request->precio_venta,'Efectivo');
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
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo completar la venta'
            ]);
        }
    }

    public function _storeqr(Request $request){
        try {
            $user = Auth::user();
            $data = array();
            $data['usr_id'] = $user->id;
            $delivery = null;
            $esProductoFeria = false;
            if ($request->has('prd_id_qr')){
                $data['prd_id'] = $request->prd_id_qr;
                $producto = $this->productoService->getById($request->prd_id_qr);
                $productor = $producto->productor;
                $delivery = $productor->deliverys->first(function ($value, $key) {
                    return $value->estado == 'AC';
                });
            }
            if ($request->has('fpr_id_qr')){
                $data['fpr_id'] = $request->fpr_id_qr;
                $productoFeria = $this->feriaProductoService->getById($request->fpr_id_qr);
                $productor = $productoFeria->productor;
                $delivery = $productor->deliverys->first(function ($value, $key) {
                    return $value->estado == 'AC';
                });
                $esProductoFeria = true;
            }
            $tipo_pagos = array(1=>'QR',2=>'Deposito',3=>'Efectivo');
            $data['tipo_pago'] = $request->tipo_pago_qr;
            $estado_ventas = array(1=>'Por Confirmar',2=>'No Concretizada',3=>'Concretizada');
            $data['estado_venta'] = 1;//por confirmar
            $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
            $data['estado_delivery'] = 1;//en proceso
            $data['estado'] = 'AC';
            $cantidad = $request->cantidad_qr;
            $precio_venta = $request->precio_venta_qr;
            if (empty($delivery)){
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo completar la venta'
                ]);
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
            if ($request->hasFile('comprobante_qr')) {
                $messages = [
                    'comprobante_qr' => 'Debe de seleccionar una imagen jpg'
                ];
                $validator = Validator::make($request->all(), [
                    'comprobante_qr' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000'
                ], $messages);

                if ($validator->fails()) {
                    return response()->json([
                        'res' => false,
                        'mensaje' => 'Imagen de comprobante no es valida, por favor ingrese una imagen (jpg) con un máximo de 2MB'
                    ]);
                }

                $tamanio = $this->parametricaService->getParametricaByTipoAndCodigo('TIPO-IMAGEN-5');
                $ruta = storage_path('app/public/uploads/');
                $file = $request->comprobante_qr;
                $extencionImagen = $file->extension();
                $nombre = 'comp'.time() . '' . uniqid() . '.' . $extencionImagen;
                $data['comprobante'] = $nombre;
                $imagen = Image::make($file);
                $imagen->resize($tamanio->valor2, $tamanio->valor3);
                $imagen->save($ruta . $nombre, 95);
            }

            $venta = $this->ventaService->save($data);

            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'ven_venta','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'registro de venta QR',
                'datos'=>json_encode($data)];
            $this->auditoriaService->save($audi);

            if (!empty($venta)){
                if (!$esProductoFeria){
                    //$envioCorreo = $this->enviarNotificacionVentaProducto($request->prd_id_qr,$request->cantidad_qr,$request->precio_venta_qr,'QR');
                }else{
                    //$envioCorreo = $this->enviarNotificacionVentaProductoFeria($request->fpr_id_qr,$request->cantidad_qr,$request->precio_venta_qr,'QR');
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
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo completar la venta'
            ]);
        }
    }

    public function _storedeposito(Request $request){
        try {
            $user = Auth::user();
            $data = array();
            $data['usr_id'] = $user->id;
            $delivery = null;
            $esProductoFeria = false;
            if ($request->has('prd_id_dp')){
                $data['prd_id'] = $request->prd_id_dp;
                $producto = $this->productoService->getById($request->prd_id_dp);
                $productor = $producto->productor;
                $delivery = $productor->deliverys->first(function ($value, $key) {
                    return $value->estado == 'AC';
                });
            }
            if ($request->has('fpr_id_dp')){
                $data['fpr_id'] = $request->fpr_id_dp;
                $productoFeria = $this->feriaProductoService->getById($request->fpr_id_dp);
                $productor = $productoFeria->productor;
                $delivery = $productor->deliverys->first(function ($value, $key) {
                    return $value->estado == 'AC';
                });
                $esProductoFeria = true;
            }
            $tipo_pagos = array(1=>'QR',2=>'Deposito',3=>'Efectivo');
            $data['tipo_pago'] = $request->tipo_pago_dp;//2 deposito
            $estado_ventas = array(1=>'Por Confirmar',2=>'No Concretizada',3=>'Concretizada');
            $data['estado_venta'] = 1;//por confirmar
            $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
            $data['estado_delivery'] = 1;//en proceso
            $data['estado'] = 'AC';
            $cantidad = $request->cantidad_dp;
            $precio_venta = $request->precio_venta_dp;
            if (empty($delivery)){
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo completar la venta'
                ]);
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
            if ($request->hasFile('comprobante_dp')) {
                $messages = [
                    'comprobante_dp' => 'Debe de seleccionar una imagen jpg'
                ];
                $validator = Validator::make($request->all(), [
                    'comprobante_dp' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000'
                ], $messages);

                if ($validator->fails()) {
                    return response()->json([
                        'res' => false,
                        'mensaje' => 'La imagen de comprobante no es valida, por favor ingrese una imagen (jpg) con un máximo de 2MB'
                    ]);
                }

                $tamanio = $this->parametricaService->getParametricaByTipoAndCodigo('TIPO-IMAGEN-5');
                $ruta = storage_path('app/public/uploads/');
                $file = $request->comprobante_dp;
                $extencionImagen = $file->extension();
                $nombre = 'comp'.time() . '' . uniqid() . '.' . $extencionImagen;
                $data['comprobante'] = $nombre;
                $imagen = Image::make($file);
                $imagen->resize($tamanio->valor2, $tamanio->valor3);
                $imagen->save($ruta . $nombre, 95);
            }

            $venta = $this->ventaService->save($data);
            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'ven_venta','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'registro de venta Deposito',
                'datos'=>json_encode($data)];
            $this->auditoriaService->save($audi);

            if (!empty($venta)){
                if (!$esProductoFeria){
                    //$envioCorreo = $this->enviarNotificacionVentaProducto($request->prd_id_dp,$request->cantidad_dp,$request->precio_venta_dp,'Deposito');
                }else{
                    //$envioCorreo = $this->enviarNotificacionVentaProductoFeria($request->fpr_id_dp,$request->cantidad_dp,$request->precio_venta_dp,'Deposito');
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
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo completar la venta'
            ]);
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

    //END GUARDADO DE LA VENTA

    //LISTA DE COMPRAS DE UN USUARIO
    public function miscompras(Request $request)
    {
        $user = Auth::user();
        $tipo_pagos = array(1=>'QR',2=>'Deposito',3=>'Efectivo');
        $estado_ventas = array(1=>'Por Confirmar',2=>'No Concretizada',3=>'Concretizada');
        /*$user = User::whereIn('id', function($query) {
            $query->select('user_id')->from('role_user');
        })->get();*/
        $ventas = $this->ventaService->getAllVentasByUsrIdAndPaginateAndSortByFecha($user->id,10);
        return view('venta.miscompras',compact('user','ventas','tipo_pagos','estado_ventas'));
    }

    public function _marcarEntregado(Request $request){
        try {
            $user = Auth::user();
            //marcamos la venta como Concretizada y marcamos el delivery como Entregado y restamos productos del stock
            $ventaConfirmada = $this->ventaService->marcarVentaComoConfirmada($request->ven_id,3,3);

            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'ven_venta','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'venta marcada como confirmada',
                'datos'=>" ven_id: $request->ven_id "];
            $this->auditoriaService->save($audi);

            if (!empty($ventaConfirmada)){
                $estadoStock = $this->revisarEstadoStockProductoByVenta($request->ven_id);
                return response()->json([
                    'res' => true,
                    'mensaje' => 'Compra confirmada'
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo confirmar la compra'
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo confirmar la compra'
            ]);
        }
    }

    public function _verEstadoDelivery(Request $request){
        $user = Auth::user();
        $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
        $venta = $this->ventaService->getById($request->ven_id);
        return view('venta._estadodelivery',compact('user','venta','estado_deliverys'));
    }
    //END LISTA DE COMPRAS DE UN USUARIO

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

    //MIS VENTAS DEL PRODUCTOR
    public function misventas($usr_id,Request $request)
    {
        $pro_id = 0;
        $user = $this->userService->getUser($usr_id);
        $productor = $this->productorService->getProductorByUser($usr_id);
        if (!empty($productor)){
            $pro_id = $productor->pro_id;
        }
        $searchtype = 1;
        $search = '';
        $sort = 1;
        if ($request->has('searchtype')){
            $searchtype = $request->searchtype;
        }
        if ($request->has('search')){
            $search = $request->search;
        }
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $tipo_pagos = array(1=>'QR',2=>'Deposito',3=>'Efectivo');
        $estado_ventas = array(1=>'Por Confirmar',2=>'No Concretizada',3=>'Concretizada');
        $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
        $ventas = $this->ventaService->getAllVentasByProIdAndPaginateAndSortByFecha($pro_id,10,$searchtype,$search,$sort);
        return view('venta.misventas',compact(
            'user',
            'ventas',
            'tipo_pagos',
            'estado_ventas',
            'estado_deliverys',
            'searchtype',
            'search',
            'sort'
        ));
    }

    public function _modificarEstadoDelivery(Request $request){
        try {
            $user = Auth::user();
            $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
            $venta = $this->ventaService->updateEstadoDelivery($request->ven_id,$request->estado_delivery);

            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'ven_venta','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'modificar estado delivery',
                'datos'=>" ven_id: $request->ven_id, estado_delivery: $request->estado_delivery "];
            $this->auditoriaService->save($audi);

            if (!empty($venta)){
                return response()->json([
                    'res'=>true,
                    'mensaje'=>'Operación completada'
                ]);
            }else{
                return response()->json([
                    'res'=>false,
                    'mensaje'=>'No se pudo modificar el estado del delivery'
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                'res'=>false,
                'mensaje'=>'No se pudo modificar el estado del delivery'
            ]);
        }
    }

    public function _cancelarVenta(Request $request){
        try {
            $user = Auth::user();
            $estado_ventas = array(1=>'Por Confirmar',2=>'No Concretizada',3=>'Concretizada');
            $venta = $this->ventaService->updateEstadoVenta($request->ven_id,2);

            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'ven_venta','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'modificar venta a no concretizada',
                'datos'=>" ven_id: $request->ven_id "];
            $this->auditoriaService->save($audi);

            if (!empty($venta)){
                return response()->json([
                    'res'=>true,
                    'mensaje'=>'Operación completada'
                ]);
            }else{
                return response()->json([
                    'res'=>false,
                    'mensaje'=>'No se pudo cancelar la venta'
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                'res'=>false,
                'mensaje'=>'No se pudo cancelar la venta'
            ]);
        }
    }

    public function _ventaCompletada(Request $request){
        try {
            $user = Auth::user();
            $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
            $estado_ventas = array(1=>'Por Confirmar',2=>'No Concretizada',3=>'Concretizada');
            $venta = $this->ventaService->marcarVentaComoConfirmada($request->ven_id,3,3);

            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'ven_venta','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'modificar venta a concretizada',
                'datos'=>" ven_id: $request->ven_id "];
            $this->auditoriaService->save($audi);

            if (!empty($venta)){
                $estadoStock = $this->revisarEstadoStockProductoByVenta($request->ven_id);
                return response()->json([
                    'res'=>true,
                    'mensaje'=>'Operación completada'
                ]);
            }else{
                return response()->json([
                    'res'=>false,
                    'mensaje'=>'No se pudo completar la venta'
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                'res'=>false,
                'mensaje'=>'No se pudo completar la venta'
            ]);
        }
    }

    public function editDelivery($ven_id){
        $user = Auth::user();
        $usr_id_vendedor = 0;
        $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
        $venta = $this->ventaService->getById($ven_id);
        $pro_id = 0;
        if (isset($venta->prd_id)){
            $pro_id = $venta->producto->pro_id;
            $usr_id_vendedor = $venta->producto->productor->usr_id;
        }elseif (isset($venta->fpr_id)){
            $pro_id = $venta->feriaProducto->pro_id;
            $usr_id_vendedor = $venta->feriaProducto->productor->usr_id;
        }
        $deliveries = $this->deliveryService->getAllAcByProductor($pro_id);
        return view('venta.editdelivery',compact('venta','deliveries','usr_id_vendedor'));
    }

    public function updateDelivery(Request $request){
        try {
            $user = Auth::user();
            $usr_id_vendedor = $request->usr_id_vendedor;
            $venta = $this->ventaService->updateDeliveryAndTotal($request->ven_id,$request->del_id,$request->precio_base_delivery,$request->subtotal);

            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'ven_venta','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'modificar delivery de la venta',
                'datos'=>" ven_id: $request->ven_id, del_id: $request->del_id, precio_base_delivery: $request->precio_base_delivery, subtotal: $request->subtotal "];
            $this->auditoriaService->save($audi);

            if (!empty($venta)){
                Toastr::success('Operación completada','');
                return redirect('venta/'.$usr_id_vendedor.'/misventas');
            }else{
                Toastr::error('No se pudo actualizar el delivery','');
                return redirect('venta/'.$usr_id_vendedor.'/misventas');
            }
        }catch (\Exception $e){
            Toastr::error('No se pudo actualizar el delivery','');
            return redirect('venta/'.$usr_id_vendedor.'/misventas');
        }
    }

    //END MIS VENTAS DEL PRODUCTOR

    //TODAS LAS VENTAS PARA EL ADMINISTRADOR
    public function ventassistema(Request $request)
    {
        $user = Auth::user();
        $searchtype = 1;
        $search = '';
        $sort = 1;
        if ($request->has('searchtype')){
            $searchtype = $request->searchtype;
        }
        if ($request->has('search')){
            $search = $request->search;
        }
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $tipo_pagos = array(1=>'QR',2=>'Deposito',3=>'Efectivo');
        $estado_ventas = array(1=>'Por Confirmar',2=>'No Concretizada',3=>'Concretizada');
        $estado_deliverys = array(1=>'En Proceso',2=>'Enviado',3=>'Entregado');
        $ventas = $this->ventaService->getAllVentasPaginateAndSearchAndSort(10,$searchtype,$search,$sort);
        return view('venta.ventassistema',compact(
            'user',
            'ventas',
            'tipo_pagos',
            'estado_ventas',
            'estado_deliverys',
            'searchtype',
            'search',
            'sort'
        ));
    }
    //END TODAS LAS VENTAS PARA EL ADMINISTRADOR

}
