<?php


namespace App\Http\Controllers;


use App\Models\CorreoEnviado;
use App\Services\CorreoEnviadoService;
use App\Services\UserService;
use App\Utils\EnviarCorreosMasivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Image;
use Notification;
use Toastr;

class EnviarCorreoMasivoController extends Controller
{
    protected $feriaVirtualService;
    protected $rubroService;
    protected $parametricaService;
    protected $imagenFeriaVirtualService;
    protected $productorService;
    protected $correoEnviadoService;
    protected $userService;
    public function __construct(
        CorreoEnviadoService $correoEnviadoService,
        UserService $userService
    )
    {
        $this->correoEnviadoService = $correoEnviadoService;
        $this->userService = $userService;
        $this->middleware('auth');
    }

    public function index()
    {
        $lista = $this->userService->getAllUsersNormalValidado();
        $nomProducto ="";
        $nombferia = '';
        $enviar_a = 'Usuarios';
        $user = Auth::user();
        $useradmin = $this->userService->getUser($user->id);
        $remitente =$useradmin->email;
        $asunto = 'ExpoCocha';
        $descripcion = '<p><b>Sr(a):</b></p>
            <p>Estimado cliente le invitamos a visitar la pagina https://www.expococha.com .Tenemos nuevos productos y ofertas de temporada</p>';
        return view('correomasivo.index',compact('lista','remitente','asunto','descripcion','enviar_a'));
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
            $user_normal_id = $decode['id'];
            $usernomal = $this->userService->getUser($user_normal_id);
            $email = $usernomal->email;
            array_push($listaIma , $email );
            $enviado_a = $email;
            $enviado_por = $correo_p;

        }

        try {
            $notificacion = new EnviarCorreosMasivo();
            $res = $notificacion->enviarCorreosMasivo($useradmin,$asunto,$descripcion,$listaIma);
            if ($res == false) {
                Toastr::warning('No se pudo guardar los correos',"");
            }
            Toastr::success('Operación completada',"");
            return redirect('enviarcorreomasivo/');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Ocurrio un error al enviar los correos',"");
            return back()->withInput();
        }
    }

}
