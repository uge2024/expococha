<?php


namespace App\Injection;


use App\Services\CarritoService;
use App\Services\InstitucionService;
use App\Services\MensajeUsuarioService;
use App\Services\PostService;
use App\User;
use Illuminate\Support\Facades\Auth;

class Carrito
{
    protected $mensajeUsuarioService;
    protected $carritoService;
    protected $institucionService;
    public function __construct(
        CarritoService $carritoService,
        MensajeUsuarioService $mensajeUsuarioService,
        InstitucionService $institucionService)
    {
        $this->carritoService = $carritoService;
        $this->mensajeUsuarioService = $mensajeUsuarioService;
        $this->institucionService = $institucionService;
    }

    public function cantidadCarrito(){
        if(Auth::check()){
            $user = Auth::user();
            $cantidad = $this->carritoService->cantidadProductosMiCarrito($user->id);
            $cantidad = $cantidad==null?0:$cantidad;
            return $cantidad;
        }else{
            return 0;
        }
    }

    public function cantidadMensajesSinLeer(){
        if(Auth::check()){
            $user = Auth::user();
            $cantidad = $this->mensajeUsuarioService->countMensajesQueMeEnviaronSinLeer($user->id);
            return $cantidad;
        }else{
            return 0;
        }
    }

    public function getDatosPagina(){
        return $this->institucionService->getById(1);
    }
}
