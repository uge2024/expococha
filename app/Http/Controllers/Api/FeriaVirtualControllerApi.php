<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dto\ErrorDto;
use App\Models\Dto\FeriaProductoCompletoDto;
use App\Models\Dto\FeriaProductoSimpleDto;
use App\Models\Dto\FeriaVirtualDto;
use App\Services\FeriaProductoService;
use App\Services\FeriaVirtualService;
use App\Services\ParametricaService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FeriaVirtualControllerApi extends Controller
{
    protected $feriaVirtualService;
    protected $feriaProductoService;
    protected $parametricaService;
    public function __construct(
        FeriaVirtualService $feriaVirtualService,
        FeriaProductoService $feriaProductoService,
        ParametricaService $parametricaService
    )
    {
        $this->feriaVirtualService = $feriaVirtualService;
        $this->feriaProductoService = $feriaProductoService;
        $this->parametricaService = $parametricaService;
    }

    public function ferias(Request $request)
    {
        try {
            $inicio = 0;
            $limite = 10;
            $orden = 2;//por defecto se ordena por fecha inicio desc
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
            $lista = new Collection();
            $ferias = $this->feriaVirtualService->getFeriasByLimitAndOrden($inicio,$limite,$orden);
            $fechaActual = date('Y-m-d');
            foreach ($ferias as $key=>$feria){
                $fer = new FeriaVirtualDto();
                $fer->fevId = $feria->fev_id;
                $fer->nombre = $feria->nombre;
                $fer->descripcion = $feria->descripcion;
                $fer->fechaInicio = $feria->fecha_inicio;
                $fer->fechaFinal = $feria->fecha_final;
                $fer->esProxima = ($feria->fecha_inicio > $fechaActual);
                $fer->estaVigente = (($feria->fecha_inicio <= $fechaActual) && ($feria->fecha_final >= $fechaActual));
                $fer->lugar = $feria->lugar;
                $fer->direccion = $feria->direccion;
                $fer->latitud = $feria->latitud;
                $fer->longitud = $feria->longitud;
                $fer->rubId = $feria->rub_id;
                $fer->rubro = $feria->rubro->nombre;
                $fer->afiche = '';
                $fer->imagenesBanner = new Collection();
                foreach ($feria->imagenFerias as $key2=>$imagen){
                    if ($imagen->estado == 'AC' && $imagen->tipo == 20){
                        $fer->afiche = asset('storage/uploads/'.$imagen->imagen);
                    }elseif ($imagen->estado == 'AC' && $imagen->tipo == 1){
                        $fer->imagenesBanner->push(asset('storage/uploads/'.$imagen->imagen));
                    }
                }
                $lista->push($fer);
            }
            return response()->json($lista->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function ver($fev_id)
    {
        try {
            $fechaActual = date('Y-m-d');
            $feria = $this->feriaVirtualService->getById($fev_id);
            $fer = new FeriaVirtualDto();
            $fer->fevId = $feria->fev_id;
            $fer->nombre = $feria->nombre;
            $fer->descripcion = $feria->descripcion;
            $fer->fechaInicio = $feria->fecha_inicio;
            $fer->fechaFinal = $feria->fecha_final;
            $fer->esProxima = ($feria->fecha_inicio > $fechaActual);
            $fer->estaVigente = (($feria->fecha_inicio <= $fechaActual) && ($feria->fecha_final >= $fechaActual));
            $fer->lugar = $feria->lugar;
            $fer->direccion = $feria->direccion;
            $fer->latitud = $feria->latitud;
            $fer->longitud = $feria->longitud;
            $fer->rubId = $feria->rub_id;
            $fer->rubro = $feria->rubro->nombre;
            $fer->afiche = '';
            $fer->imagenesBanner = new Collection();
            foreach ($feria->imagenFerias as $key2=>$imagen){
                if ($imagen->estado == 'AC' && $imagen->tipo == 20){
                    $fer->afiche = asset('storage/uploads/'.$imagen->imagen);
                }elseif ($imagen->estado == 'AC' && $imagen->tipo == 1){
                    $fer->imagenesBanner->push(asset('storage/uploads/'.$imagen->imagen));
                }
            }
            return response()->json($fer->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function productos($fev_id,Request $request)
    {
        try {
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
            $productos = $this->feriaVirtualService->getProductosFeriasByFeriaAndLimitAndOrden($fev_id,$inicio,$limite,$orden);
            $lista = new Collection();
            foreach ($productos as $key=>$pro){
                $productoDto = new FeriaProductoSimpleDto();
                $productoDto->esOferta = false;
                $productoDto->esNuevo = false;
                $productoDto->fprId = $pro->fpr_id;
                $productoDto->catId = $pro->cat_id;
                $productoDto->proId = $pro->pro_id;
                $productoDto->nombreTienda = $pro->productor->nombre_tienda;
                $productoDto->nombreProducto = $pro->nombre_producto;
                $primeraImagen = asset('images/product-image/4.jpg');
                foreach ($pro->imagenesFeriaProductos as $k=>$ima){
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

    public function verProductoFeria($fpr_id)
    {
        try {

            $producto = $this->feriaProductoService->getById($fpr_id);
            $esOferta = false;
            $esNuevo = false;
            $productoDto = new FeriaProductoCompletoDto();
            $productoDto->esOferta = $esOferta;
            $productoDto->esNuevo = $esNuevo;
            $productoDto->fprId = $producto->fpr_id;
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
            foreach ($producto->imagenesFeriaProductos as $k=>$ima){
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

}
