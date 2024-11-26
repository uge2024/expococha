<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dto\ErrorDto;
use App\Models\Dto\ProductoCompletoDto;
use App\Models\Dto\ProductoSimpleDto;
use App\Models\Dto\ValoracionProductoDto;
use App\Services\ParametricaService;
use App\Services\ProductoService;
use App\Services\ValoracionProductoService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProductoControllerApi extends Controller
{
    protected $parametricaService;
    protected $productoService;
    protected $valoracionProductoService;
    public function __construct(
        ParametricaService $parametricaService,
        ProductoService $productoService,
        ValoracionProductoService $valoracionProductoService
    )
    {
        $this->parametricaService = $parametricaService;
        $this->productoService = $productoService;
        $this->valoracionProductoService = $valoracionProductoService;
    }

    public function ofertasinicio(Request $request){
        try {
            //$productos = $this->productoService->getProductosEnOfertaRamdomByLimit(6);
            $inicio = 0;
            $limite = 10;
            $orden = 1;
            if ($request->has('inicio')){
                if (!empty($request->inicio)){
                    $inicio = $request->inicio;
                }
            }
            if ($request->has('limite')){
                if (!empty($request->limite)){
                    $limite = $request->limite;
                }
            }
            if ($request->has('orden')){
                if (!empty($request->orden)){
                    $orden = $request->orden;
                }
            }
            $productos = $this->productoService->getProductosEnOfertaByInicioAndLimitAndOrden($inicio,$limite,$orden);
            $lista = new Collection();
            foreach ($productos as $key=>$pro){
                $productoDto = new ProductoSimpleDto();
                $productoDto->esOferta = true;
                $productoDto->esNuevo = false;
                $productoDto->prdId = $pro->prd_id;
                $productoDto->catId = $pro->cat_id;
                $productoDto->proId = $pro->pro_id;
                $productoDto->nombreTienda = $pro->productor->nombre_tienda;
                $productoDto->nombreProducto = $pro->nombre_producto;
                $primeraImagen = asset('images/product-image/4.jpg');
                foreach ($pro->imagenesProducto as $k=>$ima){
                    if($ima->estado == 'AC' && $ima->tipo == 12){
                        $primeraImagen = asset('storage/uploads/'.$ima->imagen);
                        break;
                    }
                }
                $productoDto->imagen = $primeraImagen;
                $productoDto->existencia = $pro->existencia;
                $productoDto->puntuacion = $pro->puntuacion;
                $productoDto->descripcionCorta = $pro->descripcion1;
                $productoDto->precio = $pro->precio;
                $productoDto->precioOferta = $pro->precio_oferta;
                $productoDto->descuento = $pro->descuento;
                $productoDto->existenciaMinima = $pro->existencia_minima;
                $productoDto->estado = $pro->estado;
                $productoDto->fechaInicioOferta = $pro->fecha_inicio_oferta;
                $productoDto->fechaFinOferta = $pro->fecha_fin_oferta;
                $lista->push($productoDto);
            }
            return response()->json($lista->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function nuevosinicio(Request $request){
        try {
            $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
            $diasNuevos = $diasParametrica->valor1;
            //$productos = $this->productoService->getProductosNuevosRandomByLimitAndDiasNuevo(6,$diasNuevos);
            $inicio = 0;
            $limite = 10;
            $orden = 1;
            if ($request->has('inicio')){
                if (!empty($request->inicio)){
                    $inicio = $request->inicio;
                }
            }
            if ($request->has('limite')){
                if (!empty($request->limite)){
                    $limite = $request->limite;
                }
            }
            if ($request->has('orden')){
                if (!empty($request->orden)){
                    $orden = $request->orden;
                }
            }
            $productos = $this->productoService->getProductosNuevosByInicioAndLimitAndDiasNuevoAndOrden($inicio,$limite,$orden,$diasNuevos);
            $lista = new Collection();
            foreach ($productos as $key=>$pro){
                $productoDto = new ProductoSimpleDto();
                $productoDto->esOferta = false;
                $productoDto->esNuevo = true;
                $productoDto->prdId = $pro->prd_id;
                $productoDto->catId = $pro->cat_id;
                $productoDto->proId = $pro->pro_id;
                $productoDto->nombreTienda = $pro->productor->nombre_tienda;
                $productoDto->nombreProducto = $pro->nombre_producto;
                $primeraImagen = asset('images/product-image/4.jpg');
                foreach ($pro->imagenesProducto as $k=>$ima){
                    if($ima->estado == 'AC' && $ima->tipo == 12){
                        $primeraImagen = asset('storage/uploads/'.$ima->imagen);
                        break;
                    }
                }
                $productoDto->imagen = $primeraImagen;
                $productoDto->existencia = $pro->existencia;
                $productoDto->puntuacion = $pro->puntuacion;
                $productoDto->descripcionCorta = $pro->descripcion1;
                $productoDto->precio = $pro->precio;
                $productoDto->precioOferta = $pro->precio_oferta;
                $productoDto->descuento = $pro->descuento;
                $productoDto->existenciaMinima = $pro->existencia_minima;
                $productoDto->estado = $pro->estado;
                $productoDto->fechaInicioOferta = $pro->fecha_inicio_oferta;
                $productoDto->fechaFinOferta = $pro->fecha_fin_oferta;
                $lista->push($productoDto);
            }
            return response()->json($lista->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function productosinicio(Request $request){
        try {
            $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
            $diasNuevos = $diasParametrica->valor1;
            $inicio = 0;
            $limite = 10;
            $orden = 1;
            if ($request->has('inicio')){
                if (!empty($request->inicio)){
                    $inicio = $request->inicio;
                }
            }
            if ($request->has('limite')){
                if (!empty($request->limite)){
                    $limite = $request->limite;
                }
            }
            if ($request->has('orden')){
                if (!empty($request->orden)){
                    $orden = $request->orden;
                }
            }
            //$productos = $this->productoService->getProductosRandomByLimit(6,$diasNuevos);
            $productos = $this->productoService->getProductosByInicioAndLimitAndOrden($inicio,$limite,$orden,$diasNuevos);
            $lista = new Collection();
            foreach ($productos as $key=>$pro){
                $productoDto = new ProductoSimpleDto();
                $productoDto->esOferta = false;
                $productoDto->esNuevo = false;
                $productoDto->prdId = $pro->prd_id;
                $productoDto->catId = $pro->cat_id;
                $productoDto->proId = $pro->pro_id;
                $productoDto->nombreTienda = $pro->productor->nombre_tienda;
                $productoDto->nombreProducto = $pro->nombre_producto;
                $primeraImagen = asset('images/product-image/4.jpg');
                foreach ($pro->imagenesProducto as $k=>$ima){
                    if($ima->estado == 'AC' && $ima->tipo == 12){
                        $primeraImagen = asset('storage/uploads/'.$ima->imagen);
                        break;
                    }
                }
                $productoDto->imagen = $primeraImagen;
                $productoDto->existencia = $pro->existencia;
                $productoDto->puntuacion = $pro->puntuacion;
                $productoDto->descripcionCorta = $pro->descripcion1;
                $productoDto->precio = $pro->precio;
                $productoDto->precioOferta = $pro->precio_oferta;
                $productoDto->descuento = $pro->descuento;
                $productoDto->existenciaMinima = $pro->existencia_minima;
                $productoDto->estado = $pro->estado;
                $productoDto->fechaInicioOferta = $pro->fecha_inicio_oferta;
                $productoDto->fechaFinOferta = $pro->fecha_fin_oferta;
                $lista->push($productoDto);
            }
            return response()->json($lista->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function ver($prd_id,Request $request)
    {
        try {
            $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
            $diasNuevos = $diasParametrica->valor1;
            $fechaActual = date('Y-m-d');
            $fechaDesde = date("Y-m-d",strtotime($fechaActual."- $diasNuevos days"));

            $producto = $this->productoService->getById($prd_id);
            //control del producto para saber si es oferta o nuevo o normal
            $esOferta = false;
            $esNuevo = false;
            if (isset($producto->fecha_inicio_oferta) && isset($producto->fecha_fin_oferta)){
                if ($producto->fecha_inicio_oferta <= $fechaActual && $producto->fecha_fin_oferta >= $fechaActual){
                    $esOferta = true;
                }
            }elseif ($producto->fecha_registro >= $fechaDesde){
                $esNuevo = true;
            }
            $productoDto = new ProductoCompletoDto();
            $productoDto->esOferta = $esOferta;
            $productoDto->esNuevo = $esNuevo;
            $productoDto->prdId = $producto->prd_id;
            $productoDto->catId = $producto->cat_id;
            $productoDto->proId = $producto->pro_id;
            $productoDto->nombreTienda = $producto->productor->nombre_tienda;
            $productoDto->propietario = $producto->productor->nombre_propietario;

            //revisar si se puede vender por facebook
            $paginaFacebook = null;
            if(isset($producto->productor->link_facebook)){
                $linkPaginaFacebook = $producto->productor->link_facebook;
                $link = $producto->productor->link_facebook;
                $arrayLink = explode('/',$link);
                $cantidad = count($arrayLink);
                $cantidad--;
                if ($cantidad > 0){
                    while ($cantidad > 0){
                        $paginaFacebook = $arrayLink[$cantidad];
                        if ($paginaFacebook != ''){
                            $paginaFacebook = $arrayLink[$cantidad];
                            break;
                        }
                        $cantidad--;
                    }
                }
            }

            $productoDto->comprarCelularWhatsapp = $producto->productor->celular_wp;
            $productoDto->comprarLinkFacebook = empty($paginaFacebook)?null:'http://m.me/'.$paginaFacebook;
            $productoDto->comprarImagenQr = asset('storage/uploads/'.$producto->codigo_qr_venta);
            $productoDto->comprarEntidadFinanciera = $producto->productor->entidad_financiera;
            $productoDto->comprarCuenta = $producto->productor->cuenta;
            $productoDto->comprarTitularCuenta = $producto->productor->titular_cuenta;
            $productoDto->compartirLinkProducto = url('/producto/ver/'.$producto->prd_id);


            $productoDto->nombreProducto = $producto->nombre_producto;
            $imagenes = new Collection();
            foreach ($producto->imagenesProducto as $k=>$ima){
                if($ima->estado == 'AC' && $ima->tipo == 12){
                    $imagenes->push(asset('storage/uploads/'.$ima->imagen));
                }
            }
            $productoDto->imagenes = $imagenes;
            $productoDto->existencia = $producto->existencia;
            $productoDto->puntuacion = $producto->puntuacion;
            $productoDto->descripcionCorta = $producto->descripcion1;
            $productoDto->detalleProducto = $producto->descripcion2;
            $productoDto->precio = $producto->precio;
            $productoDto->precioOferta = $producto->precio_oferta;
            $productoDto->descuento = $producto->descuento;
            $productoDto->existenciaMinima = $producto->existencia_minima;
            $productoDto->estado = $producto->estado;
            $productoDto->fechaInicioOferta = $producto->fecha_inicio_oferta;
            $productoDto->fechaFinOferta = $producto->fecha_fin_oferta;
            return response()->json($productoDto->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    //buscar productos app
    public function buscarProducto(Request $request){
        try {
            $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
            $diasNuevos = $diasParametrica->valor1;
            $fechaActual = date('Y-m-d');
            $fechaDesde = date("Y-m-d",strtotime($fechaActual."- $diasNuevos days"));

            $search = '';
            $inicio = 0;
            $limite = 10;
            $orden = 1;
            if ($request->has('buscar')){
                if (!empty($request->buscar)){
                    $search = $request->buscar;
                }
            }
            if ($request->has('inicio')){
                if (!empty($request->inicio)){
                    $inicio = $request->inicio;
                }
            }
            if ($request->has('limite')){
                if (!empty($request->limite)){
                    $limite = $request->limite;
                }
            }
            if ($request->has('orden')){
                if (!empty($request->orden)){
                    $orden = $request->orden;
                }
            }

            $productos = $this->productoService->getProductosByBuscarAndLimitAndOrden($search,$inicio,$limite,$orden);
            $lista = new Collection();
            foreach ($productos as $key=>$pro){
                //control del producto para saber si es oferta o nuevo o normal
                $esOferta = false;
                $esNuevo = false;
                if (isset($pro->fecha_inicio_oferta) && isset($pro->fecha_fin_oferta)){
                    if ($pro->fecha_inicio_oferta <= $fechaActual && $pro->fecha_fin_oferta >= $fechaActual){
                        $esOferta = true;
                    }
                }elseif ($pro->fecha_registro >= $fechaDesde){
                    $esNuevo = true;
                }
                $productoDto = new ProductoSimpleDto();
                $productoDto->esOferta = $esOferta;
                $productoDto->esNuevo = $esNuevo;
                $productoDto->prdId = $pro->prd_id;
                $productoDto->catId = $pro->cat_id;
                $productoDto->proId = $pro->pro_id;
                $productoDto->nombreTienda = $pro->productor->nombre_tienda;
                $productoDto->nombreProducto = $pro->nombre_producto;
                $primeraImagen = asset('images/product-image/4.jpg');
                foreach ($pro->imagenesProducto as $k=>$ima){
                    if($ima->estado == 'AC' && $ima->tipo == 12){
                        $primeraImagen = asset('storage/uploads/'.$ima->imagen);
                        break;
                    }
                }
                $productoDto->imagen = $primeraImagen;
                $productoDto->existencia = $pro->existencia;
                $productoDto->puntuacion = $pro->puntuacion;
                $productoDto->descripcionCorta = $pro->descripcion1;
                $productoDto->precio = $pro->precio;
                $productoDto->precioOferta = $pro->precio_oferta;
                $productoDto->descuento = $pro->descuento;
                $productoDto->existenciaMinima = $pro->existencia_minima;
                $productoDto->estado = $pro->estado;
                $productoDto->fechaInicioOferta = $pro->fecha_inicio_oferta;
                $productoDto->fechaFinOferta = $pro->fecha_fin_oferta;
                $lista->push($productoDto);
            }
            //se quito por que generaba keys en los objetos del array y causaba error en la app
            //reordenamos ofertas primero
            //$lista = $lista->sortByDesc('esOferta');
            return response()->json($lista->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function valoraciones($prd_id)
    {
        try {
            $valoraciones = $this->valoracionProductoService->getValoracionesProductoByLimitSortByFechaDesc($prd_id,10);
            $lista = new Collection();
            foreach ($valoraciones as $key=>$valoracion){
                $valor = new ValoracionProductoDto();
                $valor->vpdId = $valoracion->vpd_id;
                $valor->usrId = $valoracion->usr_id;
                $valor->puntuacion = $valoracion->puntuacion;
                $valor->valoracion = $valoracion->valoracion;
                $valor->fecha = $valoracion->fecha;
                $valor->usuario = $valoracion->usuario->name;
                $lista->push($valor);
            }
            return response()->json($lista->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function storeValoracion(Request $request)
    {
        try {
            $user = Auth::user();
            $data = array();
            $data['prd_id'] = $request->prdId;
            $data['usr_id'] = $user->id;
            $data['puntuacion'] = $request->puntaje;
            $data['valoracion'] = $request->comentario;
            $data['fecha'] = date('Y-m-d H:i:s');
            $data['estado'] = 'AC';
            $valoracion = $this->valoracionProductoService->save($data);
            if (!empty($valoracion)){
                $valor = new ValoracionProductoDto();
                $valor->vpdId = $valoracion->vpd_id;
                $valor->usrId = $valoracion->usr_id;
                $valor->puntuacion = $valoracion->puntuacion;
                $valor->valoracion = $valoracion->valoracion;
                $valor->fecha = $valoracion->fecha;
                $valor->usuario = $valoracion->usuario->name;
                return response()->json($valor->toArray(),200);
            }else{
                $error = new ErrorDto();
                $error->codigo = 500;
                $error->error = 'No se pudo guardar la valoracion del producto';
                return response()->json($error->toArray(),400);
            }
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

}
