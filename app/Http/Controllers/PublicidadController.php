<?php
namespace App\Http\Controllers;

use App\Models\Publicidad;
use App\Services\AuditoriaService;
use App\Services\ParametricaService;
use App\Services\PublicidadService;
use App\Services\TipoPublicidadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Notification;
use Toastr;
use Image;

class PublicidadController extends Controller
{
    protected $tipoPublicidadService;
    protected $publicidadService;
    protected $parametricaService;
    protected $auditoriaService;
    public function __construct(
        PublicidadService $publicidadService,
        TipoPublicidadService $tipoPublicidadService,
        ParametricaService $parametricaService,
        AuditoriaService $auditoriaService
    )
    {
        $this->publicidadService = $publicidadService;
        $this->tipoPublicidadService = $tipoPublicidadService;
        $this->parametricaService = $parametricaService;
        $this->auditoriaService = $auditoriaService;
        $this->middleware('auth');
    }

    public function index()
    {
        $lista = $this->publicidadService->getAllPaginate(10);
        return view('publicidad.index', compact('lista'));
    }

    public function create()
    {
        $listacombo = $this->tipoPublicidadService->getAllCombo();
        $publicidad = new Publicidad();
        $publicidad->pub_id = 0;
        $publicidad->estado = 'AC';
        return view('publicidad.createedit',compact('publicidad','listacombo'));
    }

    public function edit($pub_id)
    {
        $listacombo = $this->tipoPublicidadService->getAllCombo();
        $publicidad = $this->publicidadService->getById($pub_id);

        return view('publicidad.createedit',compact('publicidad','listacombo'));
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        $tipoPublicidad = $this->tipoPublicidadService->getTipoPublicidadByTipo($request->tpu_id);
        $xtam = $tipoPublicidad->ancho;
        $ytam = $tipoPublicidad->alto;
        $tip = $tipoPublicidad->tipo;

        if($request->pub_id == 0 ) {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'fecha_desde.required' => 'El campo fecha_desde es requerido',
                'fecha_hasta.required' => 'El campo fecha_hasta es requerido',
                'solicitante.required' => 'EL solicitante es requerida ',
                'documento.required' => 'El documento es requerida',
                'link_destino.required' => 'El link_destino es requerida',
                'imagen.max' => 'El peso de la imagen no debe ser mayor a 4000 Mb'
            ];

            $validator = Validator::make($data, [
                'fecha_desde' => 'required',
                'fecha_hasta' => 'required',
                'solicitante' => 'required',
                'documento' => 'required',
                'link_destino' => 'required',
                'imagen' => 'mimes:png,jpeg,jpg,gif,PNG,JPEG,JPG,GIF|max:4000'
            ], $messages);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

           if ($request->hasFile('imagen')) {
                $file = $request->imagen;
                $extencionImagen =$file->extension();
                if($extencionImagen == 'gif'){
                    $nombreAlterno = time().''.uniqid();
                    $path = $request->imagen->storeAs('public/uploads/',$nombreAlterno.'.'.$extencionImagen);
                    $data['imagen'] = $nombreAlterno.'.'.$extencionImagen;
                }else{
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $data['imagen'] = $nombreUno;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize($xtam,$ytam);
                    $imagenUno->save($ruta.$nombreUno,95);
                }
            }

            $data['fecha_desde'] = str_replace('/','-',$data['fecha_desde']);
            $data['fecha_desde'] = date('Y-m-d',strtotime($data['fecha_desde']));
            $data['fecha_hasta'] = str_replace('/','-',$data['fecha_hasta']);
            $data['fecha_hasta'] = date('Y-m-d',strtotime($data['fecha_hasta']));
            $data['fecha_pago'] = str_replace('/','-',$data['fecha_pago']);
            $data['fecha_pago'] = date('Y-m-d',strtotime($data['fecha_pago']));

            try {
                    $publicidad = $this->publicidadService->save($data);
                    //logs
                    $audi = ['ip'=>$request->ip(),'tabla'=>'pub_publicidad','usuario'=>$user->id.'-'.$user->name,
                        'fecha'=>date('Y-m-d H:i:s'),'accion'=>'registro de publicidad',
                        'datos'=>json_encode($data)];
                    $this->auditoriaService->save($audi);

                    if (empty($publicidad)) {
                        Toastr::warning('No se pudo guardar la publicidad', "");
                        return back()->withInput();
                    }else{
                        Toastr::success('Operación completada ', "");
                        return redirect('publicidad');
                    }
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    Toastr::error('Ocurrio un error al guardar la publicidad', "");
                    return back()->withInput();
            }
        }else{

            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'fecha_desde.required' => 'El campo fecha_desde es requerido',
                'fecha_hasta.required' => 'El campo fecha_hasta es requerido',
                'solicitante.required' => 'EL solicitante es requerida ',
                'documento.required' => 'El documento es requerida',
                'link_destino.required' => 'El link_destino es requerida'
            ];

            $validator = Validator::make($data, [
                'fecha_desde' => 'required',
                'fecha_hasta' => 'required',
                'solicitante' => 'required',
                'documento' => 'required',
                'link_destino' => 'required'
            ], $messages);

            if ($request->hasFile('imagen')) {
                $messages = [ 'imagen.max' => 'El peso de la imagen no debe ser mayor a 4000 kilobytes'  ];
                $validator = Validator::make($data, ['imagen' => 'mimes:png,jpeg,jpg,gif,PNG,JPEG,JPG,GIF|max:4000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique la imagen', "");
                    return back()->withErrors($validator)->withInput();
                }

                $file = $request->imagen;
                $extencionImagen = $file->extension();
                if($extencionImagen == 'gif'){
                    $nombreAlterno = time().''.uniqid();
                    $path = $request->imagen->storeAs('public/uploads/',$nombreAlterno.'.'.$extencionImagen);
                    $data['imagen'] = $nombreAlterno.'.'.$extencionImagen;
                }else{
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $data['imagen'] = $nombreUno;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize($xtam,$ytam);
                    $imagenUno->save($ruta.$nombreUno,95);
                }
            }

            if ($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $data['fecha_desde'] = str_replace('/','-',$data['fecha_desde']);
            $data['fecha_desde'] = date('Y-m-d',strtotime($data['fecha_desde']));
            $data['fecha_hasta'] = str_replace('/','-',$data['fecha_hasta']);
            $data['fecha_hasta'] = date('Y-m-d',strtotime($data['fecha_hasta']));
            $data['fecha_pago'] = str_replace('/','-',$data['fecha_pago']);
            $data['fecha_pago'] = date('Y-m-d',strtotime($data['fecha_pago']));

            try {
                $publicidad = $this->publicidadService->update($data);
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'pub_publicidad','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'actualizar registro de publicidad',
                    'datos'=>json_encode($data)];
                $this->auditoriaService->save($audi);

                if (empty($publicidad)){
                    Toastr::warning('No se pudo editar la publicidad', "");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada ', "");
                    return redirect('publicidad');
                }
            }catch (\Exception $e){
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la publicidad', "");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        $user = Auth::user();
        $publcidad = $this->publicidadService->getById($request->pub_id);
        if (!empty($publcidad)) {
            if($this->publicidadService->delete($publcidad,$request->texto)){
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'pub_publicidad','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'habilitar/inhabilitar publicidad',
                    'datos'=>" pub_id: $request->pub_id, estado: $request->texto "];
                $this->auditoriaService->save($audi);

                return response()->json([
                    'res' => true
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se encontro la publicidad'
                ]);
            }
        }
        return response()->json([
            'res' => false,
            'mensaje' => 'No se encontro la publicidad'
        ]);
    }

    public function _cambiartextoavisoimagen(Request $request)
    {
      $tipoPublicidad = $this->tipoPublicidadService->getTipoPublicidadByTipo($request->tpu_id);
      $xtam = $tipoPublicidad->ancho;
      $ytam = $tipoPublicidad->alto;
      $textoaviso = 'La imagen no puede ser mayor a '.$xtam.' x '.$ytam.' pixeles y debe de ser en formato png, jpg, jpeg, gif menor a 4Mb ';
     return view('publicidad._textopublicidad',compact('textoaviso'));
    }






}
