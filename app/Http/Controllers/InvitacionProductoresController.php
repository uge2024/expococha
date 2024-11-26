<?php
namespace App\Http\Controllers;

use App\Models\CorreoEnviado;
use App\Models\Productor;
use App\Services\CorreoEnviadoService;
use App\Services\UserService;
use App\User;
use App\Utils\EnviarCorreosFerias;
use App\Services\FeriaVirtualService;
use App\Services\ImagenFeriaVirtualService;
use App\Services\ParametricaService;
use App\Services\ProductorService;
use App\Services\RubroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Image;
use Notification;
use Toastr;

class InvitacionProductoresController extends Controller
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

    public function listainvitacion()
    {
        $lista = $this->correoEnviadoService->getAllpaginate(10);
        return view('invitacionproductor.listainvitacionproductor',compact('lista'));
    }

    public function obtenerlistaproductorbyrubro(Request $request)
    {
        $rub_id = $request->rub_id;
        $listaProductores = $this->productorService->getProductoresByRubro($rub_id);
        return view('invitacionproductor._tablalistaproductores',compact('listaProductores'));
    }

    public function mandarlista(Request $request)
    {
        $user = Auth::user();
        $useradmin = $this->userService->getUser($user->id);
        $modelo = $request->json()->all();
        $modelo = (object)$modelo;
        $asunto = $modelo->asunto;
        $descripcion = $modelo->descripcion;
        $correo_p = $user->email;
        $listaIma = [];
        $cantidadimagenesbannerhay = count($modelo->datos);
        $cantidadimagenesbannerhay = $cantidadimagenesbannerhay-1;
        for($a=0; $a<=$cantidadimagenesbannerhay;$a++) {
            $decode = json_decode($modelo->datos[$a], true);
            $user_del_productor_id = $decode['usr_id'];
            $pro_id = $decode['pro_id'];
            $userproductor = $this->userService->getUser($user_del_productor_id);
            $email = $userproductor->email;
            array_push($listaIma , $email );
            $enviado_a = $email;
            $enviado_por = $correo_p;

            $correoenviado = new CorreoEnviado();
            $correoenviado->enviado_a = $enviado_a;
            $correoenviado->enviado_por = $enviado_por;
            $correoenviado->asunto = $asunto;
            $correoenviado->descripcion = $descripcion;
            $correoenviado->pro_id = $pro_id;
            $correoenviado->estado = 'AC';
            $correoenviado->save();
        }

        try {
             $notificacion = new EnviarCorreosFerias();
             $res = $notificacion->enviarCorreosFerias($useradmin,$asunto,$descripcion,$listaIma);
            if ($res == false) {
                Toastr::warning('No se pudo guardar los correos',"");
            }
            Toastr::success('Operación completada',"");
            return redirect('invitacionproductor/');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Ocurrio un error al enviar los correos',"");
            return back()->withInput();
        }
    }

    public function _obtenerdatosemail(Request $request){

        try {
            $feriaVirtual =$this->feriaVirtualService->getById($request->fev_id);
            $nombferia = $feriaVirtual->nombre;
            $dir      = $feriaVirtual->lugar;
            $fechaini = $feriaVirtual->fecha_inicio;
            $fechafin = $feriaVirtual->fecha_final;
            $fechaini = date("d/m/Y", strtotime($fechaini));
            $fechafin = date("d/m/Y", strtotime($fechafin));
            $user = Auth::user();
            $useradmin = $this->userService->getUser($user->id);
            $remitente =$useradmin->email;
            $asunto = 'Invitacion a la feria '.$nombferia;
            $descripcion = '<p><b>Sr(a):</b></p>
            <p>Se le invita cordialmente a participar de la '.$nombferia.' a realizarse en la '.$dir.' entre las fechas '.$fechaini.' a '.$fechafin.' confirmar su participacion.
            pasar por oficinas de la gobernacion</p>';

            return response()->json([
                'res' => true,
                'remitente'=>$remitente,
                'asunto'=>$asunto,
                'descripcion'=>$descripcion
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'res' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function mandarlistaantes(Request $request)
    {
        $modelo = $request->json()->all();
        $listaIma = null;
        $i = 0;
        $user_id = null;
        $pro_id = null;
        $listaIma = null;
        $cantidadimagenesbannerhay = count($modelo);
        $cantidadimagenesbannerhay = $cantidadimagenesbannerhay-1;
        for($a=0; $a<=$cantidadimagenesbannerhay;$a++) {
            $decode = json_decode($modelo[$a], true);
            $user_id = $decode['usr_id'];
            $pro_id = $decode['pro_id'];
            $fev_id = $decode['puntuacion'];
            $email = $decode['email'];
            if ($i == 0) {
                $listaIma = $email;
            }else{
                $listaIma = $listaIma . ',' . $email;
            }
            $i++;
        }
       /* Log::error("--------------------------");
        Log::error($user_id);
        Log::error($pro_id);
        Log::error($listaIma);*/
    }



}
