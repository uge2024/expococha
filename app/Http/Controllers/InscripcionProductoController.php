<?php
namespace App\Http\Controllers;
use App\Models\Productor;
use App\Services\CorreoEnviadoService;
use App\Services\FeriaVirtualService;
use App\Services\ImagenFeriaVirtualService;
use App\Services\ParametricaService;
use App\Services\ProductorService;
use App\Services\RubroService;
use App\Services\UserService;
use Illuminate\Http\Request;

class InscripcionProductoController extends Controller
{

    protected $feriaVirtualService;
    protected $rubroService;
    protected $parametricaService;
    protected $imagenFeriaVirtualService;
    protected $productorService;
    protected $correoEnviadoService;
    protected $userService;
    public function __construct(
        FeriaVirtualService $feriaVirtualService,
        RubroService $rubroService,
        ParametricaService $parametricaService,
        ImagenFeriaVirtualService $imagenFeriaVirtualService,
        Productor $productor,
        ProductorService $productorService,
        CorreoEnviadoService $correoEnviadoService,
        UserService $userService
    )
    {
        $this->feriaVirtualService = $feriaVirtualService;
        $this->rubroService = $rubroService;
        $this->parametricaService = $parametricaService;
        $this->imagenFeriaVirtualService = $imagenFeriaVirtualService;
        $this->productor = $productor;
        $this->productorService = $productorService;
        $this->correoEnviadoService = $correoEnviadoService;
        $this->userService = $userService;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $lista = $this->feriaVirtualService->getferiasHabilitadas();
        $listaProductores = array();
        $idUsuario = null;
        return view('invitacionproductor.index',compact('lista','listaProductores','idUsuario'));
    }



}
