<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dto\ErrorDto;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioControllerApi extends Controller
{
    protected $userService;
    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function getUsuarioLogeado(Request $request)
    {
        try {
            if(Auth::check()){
                $user = Auth::user();
                $res = array();
                $res['id'] = $user->id;
                $res['email'] = $user->email;
                $res['nombreCompleto'] = $user->name;
                $res['celular'] = $user->celular;
                $res['direccion'] = $user->direccion;
                $res['tipoUsuario'] = $user->rol;
                $res['tipoUsuarioLiteral'] = $user->rol==1?'Comprador':($user->rol==2?'Productor':'Administrador');
                return response()->json($res,200);
            }else{
                $error = new ErrorDto();
                $error->codigo = 401;
                $error->error = 'No autorizado';
                return response()->json($error->toArray(),401);
            }
        }catch (\Exception $e){
            $error = new ErrorDto();
            $error->codigo = $e->getCode();
            $error->error = $e->getMessage();
            return response()->json($error->toArray(),400);
        }

    }

}
