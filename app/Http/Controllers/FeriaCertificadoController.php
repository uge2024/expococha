<?php

namespace App\Http\Controllers;
use App\Models\Rubro;
use App\Services\RubroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class FeriaCertificadoController extends Controller
{
    protected $feriaCertificadoService;
    public function __construct(FeriaCertificadoService $feriaCertificadoService)
    {
        $this->feriaCertificadoService = $feriaCertificadoService;
        $this->middleware('auth');
    }

    public function index()
    {
        $lista = $this->feriaCertificadoService->getAllPaginate(10);
        return view('rubro.index',compact('lista'));
    }

    public function create()
    {
        $rubro = new Rubro();
        $rubro->rub_id = 0;
        $rubro->estado = 'AC';
        return view('rubro.createedit',compact('rubro'));
    }

    public function edit($rub_id)
    {
        $rubro = $this->rubroService->getById($rub_id);
        return view('rubro.createedit',compact('rubro'));
    }


}