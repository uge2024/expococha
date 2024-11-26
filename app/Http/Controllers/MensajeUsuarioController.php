<?php

namespace App\Http\Controllers;

use App\Services\MensajeUsuarioService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Toastr;

class MensajeUsuarioController extends Controller
{

    protected $mensajeUsuarioService;
    protected $userService;
    public function __construct(MensajeUsuarioService $mensajeUsuarioService,UserService $userService)
    {
        $this->mensajeUsuarioService = $mensajeUsuarioService;
        $this->userService = $userService;
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::check()) {
            $user = Auth::user();
            $usuarios = $this->mensajeUsuarioService->getAllUsuariosQueMeMensajearon($user->id);
            //dd($mensajesUsuarios);
            return view('mensajeusuario.index', compact('user', 'usuarios'));
        }else{
            Toastr::warning('Por favor. Ingrese al sistema para poder ver sus mensajes.','');
            return back()->withInput();
        }
    }

    public function chat($usr_id_r)
    {
        $user = Auth::user();
        if ($usr_id_r != $user->id){
            $usuarioRemitente = $this->userService->getUser($usr_id_r);
            if (isset($usuarioRemitente)){
                $mensajes = $this->mensajeUsuarioService->getAllMensajesConversacionByReceptorAndEmisor($user->id,$usr_id_r);
                return view('mensajeusuario.chat',compact('user','mensajes','usr_id_r','usuarioRemitente'));
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }

    public function _chat(Request $request)
    {
        try {
            $user = Auth::user();
            $usr_id_r = $request->usr_id;
            $meu_id = $request->meu_id;
            $mensajes = $this->mensajeUsuarioService->getAllMensajesConversacionByReceptorAndEmisorAndUltimoMensaje($user->id,$usr_id_r,$meu_id);
            $estadoUltimoMensajeEnvie = $this->mensajeUsuarioService->getEstadoVistoUltimoMensajeEnvie($usr_id_r,$user->id);
            foreach ($mensajes as $men){
                $meu_id = $men->meu_id;
            }
            $html = view('mensajeusuario._chat',compact('user','mensajes'))->render();
            return response()->json([
                'res' => true,
                'html' => $html,
                'meu_id' => $meu_id,
                'ultimovisto'=>$estadoUltimoMensajeEnvie,
                'mensaje' => ''
            ]);
        }catch (\Exception $e){
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo cargar mas mensajes.'
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $data = array();
            $data['mensaje'] = $request->mensaje;
            $data['usr_id_r'] = $request->usr_id_r;
            $data['usr_id_e'] = $user->id;
            $data['fecha'] = date('Y-m-d H:i:s');
            $data['visto'] = 0;
            $data['estado'] = 'AC';
            $mensaje = $this->mensajeUsuarioService->save($data);
            return response()->json([
               'res' => true
            ]);
        }catch (\Exception $e){
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo guardar su mensaje'
            ]);
        }
    }

}
