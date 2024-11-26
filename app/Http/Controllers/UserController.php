<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Toastr;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth');
    }

    public function miPerfil()
    {
        $user = Auth::user();
        //Toastr::success('Correcto.....', '');
        return view('usuario.miperfil',compact('user'));
    }

    public function storeDatos(Request $request)
    {
        $data = $request->except('_token');
        $messages = [
            'name.required' => 'El nombre completo es requerido',
            'celular.required' => 'El número de celular es requerido',
            'direccion.required' => 'La dirección es requerido',
        ];
        $validator = Validator::make($data, [
            'id' => 'required',
            'name' => 'required',
            'celular' => 'required',
            'direccion' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $id = $request->id;
            $user = $this->userService->actualizarDatosUsuario($id,$data);
            Toastr::success('Operación completada','');
            return redirect('usuario/miperfil');
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            Toastr::error('Ocurrio un error al guardar sus datos', "");
            return back()->withInput();
        }
    }

    public function storeContrasenia(Request $request)
    {
        $data = $request->except('_token');
        $messages = [
            'password.required' => 'La contraseña es requerido',
            'password.confirmed' => 'Las contraseñas no coinciden, intente nuevamente.',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
        ];
        $validator = Validator::make($data, [
            'id' => 'required',
            'password' => 'required|confirmed|min:8',
        ], $messages);

        if($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $id = $request->id;
            $contrasenia = $request->password;
            $user = $this->userService->actualizarContrasenia($id,$contrasenia);
            Toastr::success('Operación completada','');
            return redirect('usuario/miperfil');
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            Toastr::error('Ocurrio un error al guardar sus datos', "");
            return back()->withInput();
        }
    }

}
