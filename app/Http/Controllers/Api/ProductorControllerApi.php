<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dto\ErrorDto;
use App\Models\Dto\ProductoCompletoDto;
use App\Models\Dto\ProductorCompletoDto;
use App\Models\Dto\ProductoSimpleDto;
use App\Models\Dto\ValoracionProductorDto;
use App\Services\ParametricaService;
use App\Services\ProductorService;
use App\Services\ValoracionProductorService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProductorControllerApi extends Controller
{
    protected $productorService;
    protected $parametricaService;
    protected $valoracionProductorService;
    public function __construct(
        ProductorService $productorService,
        ParametricaService $parametricaService,
        ValoracionProductorService $valoracionProductorService
    )
    {
        $this->productorService = $productorService;
        $this->parametricaService = $parametricaService;
        $this->valoracionProductorService = $valoracionProductorService;
    }

    public function ver($pro_id)
    {
        try {
            $productor = $this->productorService->getById($pro_id);
            $productorDto = new ProductorCompletoDto();
            $productorDto->proId = $productor->pro_id;
            $productorDto->usrId = $productor->usr_id;
            $productorDto->rubId = $productor->rub_id;
            $productorDto->asoId = $productor->aso_id;
            $productorDto->asociacion = $productor->asociacion->nombre;
            $productorDto->rubro = $productor->rubro->nombre;
            $productorDto->nombrePropietario = $productor->nombre_propietario;
            $productorDto->nombreTienda = $productor->nombre_tienda;
            $productorDto->direccion = $productor->direccion;
            $productorDto->telefono1 = $productor->telefono1;
            $productorDto->telefono2 = $productor->telefono2;
            $productorDto->celular = $productor->celular;
            $productorDto->celularWhatsapp = $productor->celular_wp;
            $productorDto->actividad = $productor->actividad;
            $productorDto->email = $productor->email;
            $productorDto->longitud = $productor->longitud;
            $productorDto->latitud = $productor->latitud;
            $productorDto->linkFacebook = $productor->link_facebook;
            $productorDto->linkTwitter = $productor->link_twiter;
            $productorDto->linkInstagram = $productor->link_instagram;
            $productorDto->linkYoutube = $productor->link_youtube;
            $productorDto->puntuacion = $productor->puntuacion;
            $productorDto->imagenPrincipal = 'nnnn.jpg';
            $imagenesBanners = new Collection();
            foreach ($productor->imagenProductores as $k=>$ima){
                if($ima->estado == 'AC' && $ima->tipo == 12){
                    $productorDto->imagenPrincipal = asset('storage/uploads/'.$ima->imagen);
                }
                if($ima->estado == 'AC' && $ima->tipo == 1){
                    $imagenesBanners->push(asset('storage/uploads/'.$ima->imagen));
                }
            }
            $productorDto->imagenesBanner = $imagenesBanners;


            return  response()->json($productorDto->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function valoraciones($pro_id)
    {
        try {
            $valoraciones = $this->valoracionProductorService->getValoracionesProductorByLimitSortByFechaDesc($pro_id,10);
            $lista = new Collection();
            foreach ($valoraciones as $key=>$valoracion){
                $valor = new ValoracionProductorDto();
                $valor->vprId = $valoracion->vpr_id;
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
            $data['pro_id'] = $request->proId;
            $data['usr_id'] = $user->id;
            $data['puntuacion'] = $request->puntaje;
            $data['valoracion'] = $request->comentario;
            $data['fecha'] = date('Y-m-d H:i:s');
            $data['estado'] = 'AC';
            $valoracion = $this->valoracionProductorService->save($data);
            if (!empty($valoracion)){
                $valor = new ValoracionProductorDto();
                $valor->vprId = $valoracion->vpr_id;
                $valor->usrId = $valoracion->usr_id;
                $valor->puntuacion = $valoracion->puntuacion;
                $valor->valoracion = $valoracion->valoracion;
                $valor->fecha = $valoracion->fecha;
                $valor->usuario = $valoracion->usuario->name;
                return response()->json($valor->toArray(),200);
            }else{
                $error = new ErrorDto();
                $error->codigo = 500;
                $error->error = 'No se pudo guardar la valoracion del productor';
                return response()->json($error->toArray(),400);
            }
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function productos($pro_id,Request $request)
    {
        try {
            $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
            $diasNuevos = $diasParametrica->valor1;
            $fechaActual = date('Y-m-d');
            $fechaDesde = date("Y-m-d",strtotime($fechaActual."- $diasNuevos days"));
            $inicio = 0;
            $limite = 100;
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

            $productos = $this->productorService->getAllProductosAcByProductorAndSortAndLimit($pro_id,$inicio,$limite,$orden);
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

}
