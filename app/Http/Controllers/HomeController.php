<?php

namespace App\Http\Controllers;

use App\Services\CarritoService;
use App\Services\InstitucionService;
use App\Services\MensajeUsuarioService;
use App\Services\ParametricaService;
use App\Services\ProductorService;
use App\Services\ProductoService;
use App\Services\PublicidadService;
use App\Services\RubroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected $rubroService;
    protected $productoService;
    protected $parametricaService;
    protected $productorService;
    protected $institucionService;
    protected $publicidadService;
    protected $carritoService;
    protected $mensajeUsuarioService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ParametricaService $parametricaService
        ,ProductorService $productorService
        ,RubroService $rubroService
        ,ProductoService $productoService
        ,InstitucionService $institucionService
        ,PublicidadService $publicidadService
        ,CarritoService $carritoService
        ,MensajeUsuarioService $mensajeUsuarioService
    )
    {
        $this->rubroService = $rubroService;
        $this->productoService = $productoService;
        $this->parametricaService = $parametricaService;
        $this->productorService = $productorService;
        $this->institucionService = $institucionService;
        $this->publicidadService = $publicidadService;
        $this->carritoService = $carritoService;
        $this->mensajeUsuarioService = $mensajeUsuarioService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
        $diasNuevos = $diasParametrica->valor1;
        //LISTA DE PRODUCTOS
        //en orden aleatorio y con un limite
        $productos = $this->productoService->getProductosRandomByLimit(10,$diasNuevos);
        $productosDos = $this->productoService->getProductosRandomByLimit(10,$diasNuevos);
        //LISTA DE PRODUCTOS EN OFERTA
        $productosEnOferta = $this->productoService->getProductosEnOfertaRamdomByLimit(10);
        //LISTA DE PRODUCTOS NUEVOS
        $productosNuevos = $this->productoService->getProductosNuevosRandomByLimitAndDiasNuevo(10,$diasNuevos);
        //LISTA DE RUBRO
        $rubros = $this->rubroService->getAll();
        $limiteCategoriasRubro = 8;
        //DATOS DE LA PAGINA
        $datospagina = $this->institucionService->getById(1);
        //PUBLICIDAD
        $bannersPublicidad = $this->publicidadService->getAllPublicidadVigenteByTpuId(1);
        $cajas1Publicidad = $this->publicidadService->getAllPublicidadVigenteByTpuId(2);
        $cajas2Publicidad = $this->publicidadService->getAllPublicidadVigenteByTpuId(3);
        $modalsPublicidad = $this->publicidadService->getAllPublicidadVigenteByTpuId(4);

        return view('home',compact(
            'rubros',
            'limiteCategoriasRubro',
            'productos',
            'productosDos',
            'productosEnOferta',
            'productosNuevos',
            'datospagina',
            'bannersPublicidad',
            'cajas1Publicidad',
            'cajas2Publicidad',
            'modalsPublicidad'
        ));
    }

    public function acerca()
    {
        return view('acerca');
    }

    public function privacidad()
    {
        return view('privacidad');
    }

    public function getestados(Request $request)
    {
        try {
            if(Auth::check()){
                $user = Auth::user();
                $cantidadmensajes = $this->mensajeUsuarioService->countMensajesQueMeEnviaronSinLeer($user->id);
                $cantidadcarrito = $this->carritoService->cantidadProductosMiCarrito($user->id);
                $cantidadcarrito = $cantidadcarrito==null?0:$cantidadcarrito;
                return response()->json([
                    'res' => true,
                    'mensaje' => '',
                    'cantidadmensajes' => $cantidadmensajes,
                    'cantidadcarrito' => $cantidadcarrito
                ],200);
            }else{
                return response()->json([
                    'res' => true,
                    'mensaje' => '',
                    'cantidadmensajes' => 0,
                    'cantidadcarrito' => 0
                ],200);
            }
        }catch (\Exception $e){
            Log::error($e->getMessage(),$e->getTrace());
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo verificar los datos'
            ],200);
        }
    }

}
