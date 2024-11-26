<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\VerificarContraseniaNotification;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Notification;

class VerificarCorreoController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    //Envio de correo de verficiacion de cuenta
    public function reenviarCorreoVerificacion(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
            //dd($user);
            //envio de correo verificacion
            $fechaHoraActual = date('Y-m-d H:i:s');
            $correoUsuario = $user->email;
            $texto = $fechaHoraActual.'_&_'.$correoUsuario;
            $token = Crypt::encryptString($texto);
            $this->enviarCorreoVerificacion($user,$token);
            //return redirect('/');
            return response()->json([
                'res' => true
            ]);
        }else{
            //return redirect('/');
            return response()->json([
                'res' => false,
                'mensaje' => 'No se pudo enviar el correo electronico.'
            ]);
        }
    }

    public function validarCorreoVerificacion(Request $request, $token = null)
    {
        //dd($request,$token);
        $desencriptado = Crypt::decryptString($token);
        $horaActual = date('Y-m-d H:i:s');
        $correoRevisar = $request->email;
        $arreglo = explode('_&_',$desencriptado);
        $horaRecivido = $arreglo[0];
        $correoRecivido = $arreglo[1];
        $fecha1 = strtotime($horaActual);
        $fecha2 = strtotime($horaRecivido);
        $horas = abs($fecha1-$fecha2)/(60*60);
        $esCorreoIgual = strcmp($correoRevisar,$correoRecivido);
        $todoOk = true;
        $mensaje = '';
        if($horas>1){
            $todoOk = false;
            $mensaje = 'El link de validación ya no es valido, por favor reenvie otro.';
        }else if($esCorreoIgual <> 0){
            $todoOk = false;
            $mensaje = 'El link de validación ya no es valido, por favor reenvie otro.';
        }else{
            //aqui se verifica el usuario y su correo
            $usuario = $this->userService->getUserByEmail($correoRevisar);
            if (!empty($usuario)){
                if ($usuario->correo_validado == 0){
                    $validarCorreo = $this->userService->validarCorreoUsuario($correoRevisar);
                    if($validarCorreo == true){
                        $todoOk = true;
                        $mensaje = '!Su correo electrónico ha sido validado¡. Continue visitando nuestra página web';
                    }else{
                        $todoOk = false;
                        $mensaje = 'No se pudo validar su correo electrónico, por favor reenvie otro link de validación.';
                    }
                }else{
                    $todoOk = true;
                    $mensaje = 'Su correo electrónico ya fue validado. Continue visitando nuestra página web';
                }
            }else{
                $todoOk = false;
                $mensaje = 'No se pudo validar su correo electrónico, por favor reenvie otro link de validación.';
            }

        }
        return view('auth.verify',compact('todoOk','mensaje'));
    }

    private function enviarCorreoVerificacion($usuario,$token)
    {
        $res = true;
        try {
            Notification::send($usuario,new VerificarContraseniaNotification($token));
        }catch (\Exception $e){
            $res = false;
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
        return $res;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
