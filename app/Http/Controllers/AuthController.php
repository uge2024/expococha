<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dto\ErrorDto;
use App\Notifications\VerificarContraseniaNotification;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Notification;

class AuthController extends Controller
{
    /**
     * Registro de usuario
     */
    public function signUp(Request $request)
    {
        try {
            $validacion = $this->validator($request->all());
            if ($validacion->fails()){
                $mensaje = $validacion->errors()->first();
                $error = new ErrorDto();
                $error->codigo = 401;
                $error->error = $mensaje;
                return response()->json($error->toArray(),401);
            }

            //1 creamos al usuario
            $estado_inicial = 'AC';
            $rol_inicial = 1;
            $correo_validado = 0;
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'celular' => $request->celular,
                'direccion' => $request->direccion,
                'estado' => $estado_inicial,
                'rol' => $rol_inicial,
                'correo_validado' => $correo_validado,
            ]);

            //2 envio de correo verificacion
            $fechaHoraActual = date('Y-m-d H:i:s');
            $correoUsuario = $user->email;
            $texto = $fechaHoraActual.'_&_'.$correoUsuario;
            $token = Crypt::encryptString($texto);
            $this->enviarCorreoVerificacion($user,$token);

            //3 logeamos al usuario y creamos su token
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password, 'estado' => 'AC'])){
                $error = new ErrorDto();
                $error->codigo = 401;
                $error->error = 'No autorizado';
                return response()->json($error->toArray(),401);
            }

            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
            ],200);

        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = 'No se pudo crear al usuario - '.$e->getMessage();
            return response()->json($error->toArray(),401);
        }
    }

    protected function validator(array $data)
    {
        $messages = [
            'email.unique' => 'El correo electrónico ya está en uso, por favor ingrese otro.',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres.'
        ];
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'celular' => ['required'],
            'direccion' => ['required'],
            'password' => ['required', 'string', 'min:8'],
        ],$messages);
    }

    /**
     * Inicio de sesión y creación de token
     */
    public function login(Request $request)
    {
        try {
            $messages = [
                'email.required' => 'El correo electrónico es requerido',
                'password.required' => 'La contraseña es requerida'
            ];
            $validacion = Validator::make($request->all(), [
                'email' => ['required', 'string', 'email'],
                'password' => ['required', 'string']
            ],$messages);

            if ($validacion->fails()){
                $mensaje = $validacion->errors()->first();
                $error = new ErrorDto();
                $error->codigo = 401;
                $error->error = $mensaje;
                return response()->json($error->toArray(),401);
            }

            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password, 'estado' => 'AC'])){
                $error = new ErrorDto();
                $error->codigo = 401;
                $error->error = 'No autorizado';
                return response()->json($error->toArray(),401);
            }

            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
            ],200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = 'No se pudo iniciar session - '.$e->getMessage();
            return response()->json($error->toArray(),401);
        }
    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return response()->json([
                'message' => 'Session Logout'
            ],200);
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = 'Session cerrada';
            return response()->json($error->toArray(),500);
        }
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

}
