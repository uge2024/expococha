<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapaController extends Controller
{
    public function __construct()
    {

    }

    public function mapa(Request $request)
    {
        $latitud = -17.393871;
        $longitud = -66.156957;
        $zoom = 18;
        $direccion = 'Sin Dirección';
        if ($request->has('latitud')){
            $latitud = $request->latitud;
        }
        if ($request->has('longitud')){
            $longitud = $request->longitud;
        }
        if ($request->has('zoom')){
            $zoom = $request->zoom;
        }
        if ($request->has('direccion')){
            $direccion = $request->direccion;
        }
        return view('mapa.mapa',compact('latitud','longitud','zoom','direccion'));
    }

}
