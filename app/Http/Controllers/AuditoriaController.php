<?php

namespace App\Http\Controllers;

use App\Services\AuditoriaService;
use App\Services\InstitucionService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use PDF;

class AuditoriaController extends Controller
{
    protected $auditoriaService;
    protected $institucionService;
    public function __construct(
        AuditoriaService $auditoriaService,
        InstitucionService $institucionService
    )
    {
        $this->auditoriaService = $auditoriaService;
        $this->institucionService = $institucionService;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $limit = 10;
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $fecha_inicio = date('d/m/Y');
        $fecha_fin = date('d/m/Y');
        if ($request->has('search')){
            $searchtype = $request->searchtype;
            $search = $request->search;
        }
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        if ($request->has('fecha_inicio')){
            $fecha_inicio = $request->fecha_inicio;
        }
        if ($request->has('fecha_fin')){
            $fecha_fin = $request->fecha_fin;
        }
        if ($request->has('btnprint')){
            $institucion = $this->institucionService->getById(1);
            $tituloReporte = 'Log Sistema';
            $subtituloReporte = " Desde: $fecha_inicio Hasta: $fecha_fin ";

            //set_time_limit(300);
            $lista = $this->auditoriaService->getTodosBySearchAndSort($searchtype,$search,$sort,$fecha_inicio,$fecha_fin);
            $pdf = PDF::loadView('auditoria.report',compact(
                'user',
                'tituloReporte',
                'subtituloReporte',
                'institucion',
                'lista'
            ));
            $pdf->setPaper('letter', 'landscape');
            return $pdf->stream('log_sistema.pdf');
        }else{
            $lista = $this->auditoriaService->getTodosPaginateBySearchAndSort($limit,$searchtype,$search,$sort,$fecha_inicio,$fecha_fin);
            return view('auditoria.index',compact('lista','searchtype','search','sort','fecha_inicio','fecha_fin'));
        }

    }

}
