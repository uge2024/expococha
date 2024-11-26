<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dto\ErrorDto;
use App\Models\Dto\ProductoSimpleDto;
use App\Models\Dto\RubroDto;
use App\Services\ParametricaService;
use App\Services\ProductoService;
use App\Services\RubroService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RubroControllerApi extends Controller
{
    protected $rubroService;
    protected $parametricaService;
    protected $productoService;
    public function __construct(
        RubroService $rubroService,
        ParametricaService $parametricaService,
        ProductoService $productoService
    )
    {
        $this->rubroService = $rubroService;
        $this->parametricaService = $parametricaService;
        $this->productoService = $productoService;
    }

    public function rubros(){
        try {
            $rubros = $this->rubroService->getAllByAc();
            $lista = new Collection();
            foreach ($rubros as $key=>$rub){
                $rubroDto = new RubroDto();
                $rubroDto->rubId = $rub->rub_id;
                $rubroDto->nombre = $rub->nombre;
                $rubroDto->descripcion = $rub->descripcion;
                $rubroDto->estado = $rub->estado;
                $rubroDto->imagenBanner = asset('storage/uploads/'.$rub->imagen_banner);
                $rubroDto->imagenIcono = asset('storage/uploads/'.$rub->imagen_icono);
                $lista->push($rubroDto);
            }
            return response()->json($lista->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

    public function getProductosByRubro($rub_id,Request $request)
    {
        try {
            $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
            $diasNuevos = $diasParametrica->valor1;
            $fechaActual = date('Y-m-d');
            $fechaDesde = date("Y-m-d",strtotime($fechaActual."- $diasNuevos days"));
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
            $productos = $this->productoService->getProductosByRubroAndLimitAndOrden($rub_id,$inicio,$limite,$orden);
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
                $productoDto->prdId = $pro->prd_id;
                $productoDto['esOferta'] = $esOferta;
                $productoDto['esNuevo'] = $esNuevo;
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
            //posible solucion al doble ordenado, pero es mucha carga
            //$lista = $lista->sortByDesc('esNuevo')->sortByDesc('esOferta');
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