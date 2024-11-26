<?php

namespace App\Http\Controllers;

use App\Notifications\VerificarContraseniaNotification;
use App\Services\AuditoriaService;
use App\Services\InstitucionService;
use App\Services\ProductorService;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Notification;
use Toastr;
use PDF;

class AdministracionController extends Controller
{
    protected $userService;
    protected $productorService;
    protected $institucionService;
    protected $auditoriaService;
    public function __construct(
        UserService $userService,
        ProductorService $productorService,
        InstitucionService $institucionService,
        AuditoriaService $auditoriaService
    )
    {
        $this->userService = $userService;
        $this->productorService = $productorService;
        $this->institucionService = $institucionService;
        $this->auditoriaService = $auditoriaService;
        $this->middleware('auth');
    }

    /**
     * usuarios para la administracion
     */
    public function usuarios(Request $request)
    {
        $user = Auth::user();
        $searchtype = 1;
        $search = '';
        $sort = 1;
        if ($request->has('search')){
            $searchtype = $request->searchtype;
            $search = $request->search;
        }
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $roles = array(1=>'Normal',2=>'Productor',3=>'Administrador');
        $lista = $this->userService->getTodosUsuariosPaginateBySearchAndSort(10,$searchtype,$search,$sort);
        return view('administracion.usuario.index',compact('lista','roles','searchtype','search','sort'));
    }

    public function usuarioCreate()
    {
        $user = Auth::user();
        $usuario = new User();
        $usuario->id = 0;
        $usuario->estado = 'AC';
        $usuario->rol = 2;
        $roles = array(1=>'Normal',2=>'Productor',3=>'Administrador');
        return view('administracion.usuario.create',compact('usuario','roles'));
    }

    public function usuarioStore(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        $messages = [
            'name.required' => 'El nombre completo es requerido',
            'celular.required' => 'El número de celular es requerido',
            'direccion.required' => 'La dirección es requerido',
            'email.email' => 'Debe ingresar un correo electrónico valido',
            'email.unique' => 'El correo electrónico ya está en uso, por favor ingrese otro.',
            'password.required' => 'La contraseña es requerido',
            'password.confirmed' => 'Las contraseñas no coinciden, intente nuevamente.',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
        ];
        $validator = Validator::make($data, [
            'id' => 'required',
            'name' => 'required',
            'celular' => 'required',
            'direccion' => 'required',
            'email' => 'required|email|unique:users|max:255',
            'rol' => 'required',
            'password' => 'required|confirmed|min:8'
        ], $messages);

        if($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data['usr_id_creador'] = $user->id;
            $usuario = $this->userService->saveUsuario($data);
            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'users','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'agregar nuevo usuario desde el panel del administrador',
                'datos'=>json_encode($data)];
            $this->auditoriaService->save($audi);

            if (!empty($usuario)){
                $fechaHoraActual = date('Y-m-d H:i:s');
                $correoUsuario = $usuario->email;
                $texto = $fechaHoraActual.'_&_'.$correoUsuario;
                $token = Crypt::encryptString($texto);
                $this->enviarCorreoVerificacion($usuario,$token);
                Toastr::success('Operación completada','');
                return redirect('/administracion/usuarios');
            }else{
                Toastr::error('Ocurrio un error al guardar el usuario', "");
                return back()->withInput();
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            Toastr::error('Ocurrio un error al guardar el usuario', "");
            return back()->withInput();
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

    public function usuarioEdit($id)
    {
        $user = Auth::user();
        $usuario = $this->userService->getUser($id);
        $roles = array(1=>'Normal',2=>'Productor',3=>'Administrador');
        return view('administracion.usuario.edit',compact('usuario','roles'));
    }

    public function usuarioUpdate(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        $messages = [
            'name.required' => 'El nombre completo es requerido',
            'celular.required' => 'El número de celular es requerido',
            'direccion.required' => 'La dirección es requerido',
            'email.email' => 'Debe ingresar un correo electrónico valido',
            'email.unique' => 'El correo electrónico ya está en uso, por favor ingrese otro.',
        ];
        $validator = Validator::make($data, [
            'id' => 'required',
            'name' => 'required',
            'celular' => 'required',
            'direccion' => 'required',
            'email' => 'required|email|unique:users,email,'.$data['id'].'|max:255',
            'rol' => 'required',
        ], $messages);

        if($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data['usr_id_creador'] = $user->id;
            $usuario = $this->userService->updateUsuarioWithoutPassword($data);
            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'users','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'actualizar usuario desde el panel del administrador',
                'datos'=>json_encode($data)];
            $this->auditoriaService->save($audi);

            if (!empty($usuario)){
                Toastr::success('Operación completada','');
                return redirect('/administracion/usuarios');
            }else{
                Toastr::error('Ocurrio un error al actualizar el usuario', "");
                return back()->withInput();
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            Toastr::error('Ocurrio un error al actualizar el usuario', "");
            return back()->withInput();
        }
    }

    public function changepassword($id)
    {
        $user = Auth::user();
        $usuario = $this->userService->getUser($id);
        return view('administracion.usuario.changepassword',compact('usuario'));
    }

    public function storechangepassword(Request $request)
    {
        $user = Auth::user();
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
            $usuario = $this->userService->actualizarContrasenia($id,$contrasenia);
            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'users','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'actualizar contraseña usuario desde el panel del administrador',
                'datos'=>" usr_id: $id "];
            $this->auditoriaService->save($audi);

            Toastr::success('Operación completada','');
            return redirect('/administracion/usuarios');
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            Toastr::error('Ocurrio un error al modificar la contraseña', "");
            return back()->withInput();
        }
    }

    public function _modificarEstado(Request $request)
    {
        $user = Auth::user();
        $usuario = $this->userService->getUser($request->id);
        $usuario->estado = $request->estado;
        try {
            $usuario->usr_id_creador = $user->id;
            $user = $this->userService->updateUsuarioWithoutPassword($usuario);
            if (!empty($user)){
                return response()->json([
                    'res' => true
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo modificar el usuario'
                ]);
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    /**
     * Administracion de productores
     */
    public function productores(Request $request)
    {
        $user = Auth::user();
        $searchtype = 1;
        $search = '';
        $sort = 1;
        if ($request->has('search')){
            $searchtype = $request->searchtype;
            $search = $request->search;
        }
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $lista = $this->productorService->getAllPaginateBySearchAndSort(10,$searchtype,$search,$sort);
        return view('administracion.productor.index',compact('lista','searchtype','search','sort'));
    }

    public function _modificarEstadoProductor(Request $request)
    {
        $user = Auth::user();
        try {
            $productorUpdate = $this->productorService->updateEstadoTienda($request->id,$request->estado);
            //logs
            $audi = ['ip'=>$request->ip(),'tabla'=>'pro_productor','usuario'=>$user->id.'-'.$user->name,
                'fecha'=>date('Y-m-d H:i:s'),'accion'=>'habilitar / inhabilitar tienda del productor desde el panel del administrador',
                'datos'=>" pro_id: $request->id, estado: $request->estado "];
            $this->auditoriaService->save($audi);

            if (!empty($productorUpdate)){
                return response()->json([
                    'res' => true
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo modificar el productor'
                ]);
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function catalogoProductor($pro_id)
    {
        $user = Auth::user();
        $productor = $this->productorService->getById($pro_id);
        $institucion = $this->institucionService->getById(1);
        $titulo = 'Catalogo de Productos';
        $subtitulo = 'Productor: '.$productor->nombre_tienda;
        $productos = $this->productorService->getAllProductosAcByProductor($pro_id);

        //set_time_limit(300);

        $pdf = PDF::loadView('administracion.productor.catalogo_reporte',compact(
            'user',
            'titulo',
            'subtitulo',
            'productor',
            'institucion',
            'productos'
        ));
        $pdf->setPaper('letter', 'landscape');
        return $pdf->stream('catalogo_productor.pdf');
    }

}
