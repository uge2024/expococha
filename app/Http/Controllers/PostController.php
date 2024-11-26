<?php

namespace App\Http\Controllers;


use App\Notifications\MensajeMasivoNotification;
use App\Utils\EnviarCorreosFerias;
use Illuminate\Http\Request;
use App\Services\PostService;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Image;
use Illuminate\Support\Facades\Storage;
use Notification;
use App\Notifications\VerificarContraseniaNotification;
use App\User;
use Illuminate\Support\Facades\Crypt;

class PostController extends Controller
{
    protected $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $lista = new Collection();
        if ($request->has('ordenar')){
            $lista = $this->postService->getPaginateWithOrderBy(11,1);
        }else{
            $lista = $this->postService->getPaginate(10);
        }

        return view('post.index',compact('lista'));
    }

    public function index2()
    {
        /*$result = ['status'=>200];
        try {
            $result['data'] = $this->postService->getAll();
        }catch (Exception $e){
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);*/
        $texto = date('Y-m-d H:i:s').'_&_ruddy.marquina@gmail.com';
        //Hash::make()
        $encriptado = Crypt::encryptString($texto);
        $desencriptado = Crypt::decryptString($encriptado);

        $horaActual = date('Y-m-d H:i:s');
        $correoRevisar = 'ruddy.marquina@gmail.com';

        $arreglo = explode('_&_',$desencriptado);
        $horaRecivido = $arreglo[0];
        $correoRecivido = $arreglo[1];

        /*$fecha1 = new DateTime($horaActual);
        $fecha2 = new DateTime($horaRecivido);*/

        $fecha1 = strtotime($horaActual);
        $fecha2 = strtotime($horaRecivido);

        $horas = abs($fecha1-$fecha2)/(60*60);
        $esCorreoIgual = strcmp($correoRevisar,$correoRecivido);

        $lista = $this->postService->getAll();
        return view('post.index',compact('lista','encriptado','desencriptado','horas','esCorreoIgual'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        //ejemplo de uno solo
        /*$usuario = User::find(1);
        $midato = 'ruddy';
        Notification::send($usuario,new VerificarContraseniaNotification($midato));*/

        try {
            //ejemplo de envio masivo de correos 1
            /*$usuarios = User::whereIn('id',[1,5,6])->get();
            foreach ($usuarios as $usuario){
                $midato = $usuario->name;
                Notification::send($usuario,new VerificarContraseniaNotification($midato));
            }*/

            //ejemplo de envio masivo de correos 2
            //funciona, si alguno de los correos no existe no importa
            //los siguientes se enviar igual

            /*$usuarios = User::whereIn('id',[1,2,5])->get();
            $midato = 'envio masivo 2';
            Notification::send($usuarios,new VerificarContraseniaNotification($midato));*/

        }catch (\Exception $e){
            Log::error($e->getMessage());
        }


        /*for ($i=1000;$i<2000;$i++)
        {
            $dato = array();
            $dato['titulo'] = 'titulo '.$i;
            $dato['descripcion'] = 'descripcion '.$i;
            $dato['fecha'] = date('Y-m-d');
            $dato['bandera'] = true;
            $dato['valor_a'] = 12.1 + $i;
            $dato['valor_b'] = 12.1 + $i;
            $dato['valor_c'] = 12.1 + $i;
            $dato['valor_d'] = $i;
            $dato['fecha_hora'] = date('Y-m-d');
            $post = $this->postService->savePostData2($dato);
        }*/

        return view('post.create');
    }


    public function store(Request $request)
    {
        //dd($request);

        $data = $request->except('_token');

        $messages = [
            //'required' => 'El campo :attribute es requerido.',
            'descripcion.required' => 'El campo descripcion dos es requerido',
            'imagen.max' => 'Debe seleccionar solo 1 imagen',
        ];

        $validator = Validator::make($data, [
            'titulo' => 'required',
            'descripcion' => 'required',
            'imagen' =>'required|min:1|max:1',
            'imagen.*' => 'mimes:jpeg,jpg,png,JPEG,JPG|max:100',

        ],$messages);

        if ($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        //dd($request);

        if($request->hasFile('imagen')){
            /*$extension = $request->imagen->extension();
            $nombreAlterno = date('YmdHmsu')."logo";
            $path = $request->imagen->storeAs('public/uploads/',$nombreAlterno.'.'.$extension);
            $data['descripcion'] = $nombreAlterno.'.'.$extension;*/

            /*$imagen = $request->imagen;
            $nuevo_nombre = time().'.'.$imagen->extension();
            $idTienda = 1;
            $ruta_parcial = 'uploads/tienda'.$idTienda;
            $ruta_destino = storage_path($ruta_parcial);
            $ruta_destino_final = $ruta_destino.'/'.$nuevo_nombre;
            $nueva_imagen = Image::make($imagen->path());
            $nueva_imagen->resize(300,300,function ($constraint){
                $constraint->aspectRatio();
            })->save($ruta_destino_final);

            $nuevo_nombre2 = time().'.'.$imagen->extension();
            $imagen->move($ruta_destino,$nuevo_nombre2);

            $data['descripcion'] = $ruta_destino_final;*/


            $files = $request->file('imagen');
            foreach($files as $file) {
                //dd(storage_path('app/public/uploads'));
                /*$ruta1 = storage_path('app/public/');

                $originalImage= $file;
                $extensionImagen = $originalImage->extension();
                $nombreUno = date('YmdHmsu').'.'.$extensionImagen;
                $nombreDos = date('YmdHmsu').'.'.$extensionImagen;
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = $ruta1.'uploads/';
                $originalPath = $ruta1.'uploads/';*/
                /*$thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
                $thumbnailImage->resize(1920,480);
                $thumbnailImage->save($thumbnailPath.time().$originalImage->getClientOriginalName());*/
                /*$thumbnailImage->save($originalPath.$nombreUno);
                $thumbnailImage->resize(1920,480);
                $thumbnailImage->save($thumbnailPath.$nombreDos);*/

                $ruta = storage_path('app/public/uploads/');
                $extensionImagen = $file->extension();
                $nombreUno = time().''.uniqid().'.'.$extensionImagen;
                $nombreDos = time().''.uniqid().'.'.$extensionImagen;
                $imagenUno = Image::make($file);
                $imagenDos = Image::make($file);
                //60 calidad media 100 seria calidad alta y pesado
                $imagenUno->save($ruta.$nombreUno,60);
                $imagenDos->resize(1920,480);
                $imagenDos->save($ruta.$nombreDos,60);

            }

        }





        //dd($data);
        try {
            $post = $this->postService->savePostData2($data);
            if (empty($post)){
                throw new Exception("No se pudo guardar el modelo post");
            }
            return redirect('post');
        }catch (Exception $e){
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function otro()
    {
        $data = [
            'titulo'=>'dos',
            'descripcion'=>'dos descripcion',
            'fecha'=>date('Y-m-d'),
            'bandera'=>false,
            'valor_a'=>13.1,
            'valor_b'=>13.2,
            'valor_c'=>13.3,
            'valor_d'=>13,
            'fecha_hora'=>date('Y-m-d')
        ];

        $result = ['status' => 200];

        try {
            /*$res = $this->postService->savePostData($data);
            if ($res == null){

            }else{
                $result['data'] = $res;
            }*/
            $result['data'] = $this->postService->savePostData($data);

        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function tienda()
    {

        return view('post.tienda');
    }

    public function mensaje()
    {
        return view('post.mensaje');
    }

    public function _mensaje(Request $request){
        $cantidad = 2;
        //$i = 5/0;
        return view('post._mensaje',compact('cantidad'));
    }

    public function enviarmasivo()
    {
        $user = User::find(1);
        $asunto = 'Ferias';
        $mensaje = '<h1>The ol and ul elements</h1>
                    <p>The ol element defines an ordered list:</p>
                    <ol>
                      <li>Coffee</li>
                      <li>Tea</li>
                      <li>Milk</li>
                    </ol>

                    <p>The ul element defines an unordered list:</p>
                    <ul>
                      <li>Coffee</li>
                      <li>Tea</li>
                      <li>Milk</li>
                    </ul>';
        $correos = ['ariel.ramer4@gmail.com'];
        //$this->enviarcorreosmasivos($user,$asunto,$mensaje,$correos);

        $res = false;
        $notificacion = new EnviarCorreosFerias();
        $user = User::find(1);
        $res = $notificacion->enviarCorreosFerias($user,$asunto,$mensaje,$correos);
        //$res = $this->enviarCorreosFerias($asunto,$mensaje,$correos);

        return 'TODO BIEN '.$res;
    }

    private function enviarCorreosFerias($asunto,$mensaje,$correos)
    {
        $res = true;
        $user = User::find(1);
        /*$user->id = 1;
        $user->name = 'Infor Gobernacion';
        $user->email = 'info.pymes.gobernacion@gmail.com';
        $user->password = 'rrrr';
        $user->created_at = '2020-01-01 00:00:00';
        $user->updated_at = '2020-01-01 00:00:00';
        $user->estado = 'AC';*/
        try {
            Notification::send($user,new MensajeMasivoNotification($asunto,$mensaje,$correos));
        }catch (\Exception $e){
            $res = false;
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
        return $res;
    }

    private function enviarcorreosmasivos($user,$asunto,$mensaje,$correos)
    {
        $res = true;
        try {
            Notification::send($user,new MensajeMasivoNotification($asunto,$mensaje,$correos));
        }catch (\Exception $e){
            $res = false;
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
        return $res;
    }

    public function ejecutarSql()
    {
        //15-06-2021
        /*DB::select("TRUNCATE public.notifications RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.oauth_access_tokens RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.aud_auditoria RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.pos_post RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.pub_publicidad RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.ife_imagen_feria RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.ipf_imagen_producto_feria RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.ipd_imagen_producto RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.ven_venta RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.ipr_imagen_productor RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.car_carrito RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.cee_certificado_emitido RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.fec_feria_certificado RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.den_denuncia RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.vpf_valoracion_producto_feria RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.vpd_valoracion_producto RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.vpr_valoracion_productor RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.meu_mensaje_usuario RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.del_delivery RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.cen_correo_enviado RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.prd_producto RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.fpr_feria_producto RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.cat_categoria_rubro RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.fpd_feria_productor RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.fev_feria_virtual RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.pro_productor RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.aso_asociacion RESTART IDENTITY CASCADE");
        DB::select("TRUNCATE public.rub_rubro RESTART IDENTITY CASCADE");

        DB::select("TRUNCATE public.users RESTART IDENTITY CASCADE");

        DB::select("INSERT INTO public.users(
	    name, email, email_verified_at, password, remember_token, created_at, updated_at, estado, rol, correo_validado, usr_id_creador, celular, direccion)
	    VALUES ('Juan Antezana', 'juantezana67@gmail.com', '2020-12-14 11:09:07','".'$2y$10$j0wvbiRky1HcpxGJsdFcOuKQvEQRvq.MImn/5ooJWRb3w9gAHubWK'."', null, '2020-12-14 11:07:43', '2020-12-14 11:09:07', 'AC', 3, 1, null, 77974242, 'Av. Petrolera')");*/

        //antes febrero 2021
        //DB::select("ALTER TABLE public.pro_productor ADD COLUMN titular_cuenta character varying(200)");

        return 'ok';
    }

}
