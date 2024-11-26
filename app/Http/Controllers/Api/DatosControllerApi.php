<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dto\DatosDto;
use App\Models\Dto\ErrorDto;
use App\Services\InstitucionService;
use Illuminate\Http\Request;

class DatosControllerApi extends Controller
{
    protected $institucionService;
    public function __construct(InstitucionService $institucionService)
    {
        $this->institucionService = $institucionService;
    }

    public function datosIniciales()
    {
        try {
            $institucion = $this->institucionService->getById(1);
            $dato = new DatosDto();
            $dato->sigla = $institucion->sigla;
            $dato->nombre = $institucion->nombre;
            $dato->descripcion = $institucion->descripcion;
            $dato->direccion = $institucion->direccion;
            $dato->imagenIcono = asset('storage/uploads/'.$institucion->imagen_icono);
            $dato->imagenBanner = asset('storage/uploads/'.$institucion->imagen_banner);
            $dato->linkFacebook = $institucion->link_facebook;
            $dato->linkTwitter = $institucion->link_twiter;
            $dato->linkInstagram = $institucion->link_instagram;
            $dato->linkYoutube = $institucion->link_youtube;
            $dato->celular = $institucion->celular;
            $dato->celularWhatsapp = $institucion->celular_wp;
            return response()->json($dato->toArray(),200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }
    }

}
