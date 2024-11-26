<?php

namespace App\Http\Controllers;

use App\Models\ImagenProductor;
use App\Models\Productor;
use App\Services\AsociacionService;
use App\Services\AuditoriaService;
use App\Services\DeliveryService;
use App\Services\ImagenProductorService;
use App\Services\ParametricaService;
use App\Services\UserService;
use App\Services\ProductorService;
use App\Services\ProductoService;
use App\Services\RubroService;
use App\Services\ValoracionProductorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Image;
use Notification;
use Toastr;

class ProductorController extends Controller
{
    protected $productorService;
    protected $rubroService;
    protected $imagenProductorService;
    protected $parametricaService;
    protected $valoracionProductorService;
    protected $asociacionService;
    protected $deliveryService;
    protected $productoService;
    protected $userService;
    protected $auditoriaService;
    public function __construct(
        ProductorService $productorService,
        RubroService $rubroService,
        ImagenProductorService $imagenProductorService,
        ParametricaService $parametricaService,
        ValoracionProductorService $valoracionProductorService,
        AsociacionService $asociacionService,
        DeliveryService $deliveryService,
        ProductoService $productoService,
        UserService $userService,
        AuditoriaService $auditoriaService
    )
    {
        $this->productorService = $productorService;
        $this->rubroService = $rubroService;
        $this->imagenProductorService = $imagenProductorService;
        $this->parametricaService = $parametricaService;
        $this->valoracionProductorService = $valoracionProductorService;
        $this->asociacionService = $asociacionService;
        $this->deliveryService = $deliveryService;
        $this->productoService = $productoService;
        $this->userService = $userService;
        $this->auditoriaService = $auditoriaService;
    }

    public function index()
    {
        $lista = $this->productorService->getAllPaginate(10);
        return view('productor.index',compact('lista'));
    }

    public function createeditproductor($usr_id)
    {
        $listaasociaciones = $this->asociacionService->getAsociacionCombo();
        $productorexistente = $this->productorService->getProductorByUser($usr_id);
        $param = $this->parametricaService->getParametricaByTipoAndCodigo("ZOOM-PRODUCTOR-MAPA-1");
        $nombreRubro = '';
        $nombreAsociacion = '';
        $user2 = Auth::user();
        $user = $this->userService->getUser($usr_id);
        $tipoUsuario = $user2->rol;
        $zoom = $param->valor1;
        if(!$productorexistente){
            if($tipoUsuario == 3){
                $productor = new Productor();
                $productor->pro_id = 0;
                $productor->estado = 'AC';
                $productor->estado_tienda = 'AC';
                $productor->latitud = $param->valor2;
                $productor->longitud = $param->valor3;
                $listarubro = $this->rubroService->getComboRubros();
                return view('productor.createedit',compact('tipoUsuario','nombreRubro','productor','listarubro','usr_id','listaasociaciones'));
            }else{
                Toastr::warning('Sus datos del productor no estan registrados comuniquese con el administrador del portal', "");
                 return redirect('/');
            }
        }else{
            $rubro = $this->rubroService->getById($productorexistente->rub_id);
            $nombreRubro = $rubro->nombre;
            $asociacion = $this->asociacionService->getById($productorexistente->aso_id);
            $nombreAsociacion = $asociacion->nombre;
            $productor = $this->productorService->getById($productorexistente->pro_id);
            $listarubro = $this->rubroService->getComboRubros();
            $ipd_id_icono = 0;
            $ipd_id_medio = 0;
            $imagenMedio=null;
            $imagenIcono=null;
            $cantidadimagenesbannerhay=null;
            $imagenesBanners = $this->imagenProductorService->getListaImagenProductorByProductor($productor->pro_id,1);
            $cantidadimagenesbannerhay = count($imagenesBanners);
            foreach($productor->imagenProductores as $nuevaImagenProducto) {
                if($nuevaImagenProducto->tipo == 8 ){
                    if($nuevaImagenProducto->estado=='AC'){
                        $imagenMedio = $nuevaImagenProducto->imagen;
                        $ipd_id_medio = $nuevaImagenProducto->ipd_id;
                    }
                }
                if($nuevaImagenProducto->tipo == 12 ){
                    if($nuevaImagenProducto->estado =='AC') {
                        $imagenIcono = $nuevaImagenProducto->imagen;
                        $ipd_id_icono = $nuevaImagenProducto->ipd_id;
                    }
                }
            }
            $limiteImagen = 5 - $cantidadimagenesbannerhay;
            return view('productor.createedit',compact('tipoUsuario','nombreRubro','nombreAsociacion','productor','listarubro','usr_id','imagenIcono','imagenesBanners','ipd_id_icono','ipd_id_medio','cantidadimagenesbannerhay','zoom','listaasociaciones','limiteImagen'));
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $tamanioImagenG = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN_1");
        $tamanioImagenM = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
        $tamanioImagenP = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-12");

        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        $data['fecha_registro'] = date('Y-m-d');
        $data['puntuacion'] = 3;
        $xg=$tamanioImagenG->valor2;
        $yg=$tamanioImagenG->valor3;
        $tipog=$tamanioImagenG->valor1;
        $xm=$tamanioImagenM->valor2;
        $ym=$tamanioImagenM->valor3;
        $tipom=$tamanioImagenM->valor1;
        $xp=$tamanioImagenP->valor2;
        $yp=$tamanioImagenP->valor3;
        $tipop=$tamanioImagenP->valor1;
        if($request->pro_id == 0 ) {
            if(intval($data['rub_id']) == 0){
                Toastr::warning('Debe de seleccionar un rubro', "");
                return back()->withInput();
            }else{
                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                    'nombre_propietario.required' => 'El campo nombre es requerido',
                    'direccion.required' => 'La direccion es requerida ',
                    'rub_id.required' => 'Debe de seleccionar un rubro ',
                    'celular.required' => 'El campo celular es requerida',
                    'celular_wp.required' => 'El campo celular whatsapp es requerida',
                    'nombre_tienda.required' => 'El campo nombre tienda es requerido',
                    'actividad.required' => 'El campo actividad es requerido',
                    'email.required' => 'El campo email es requerido',
                    'imagen_banner.max' => 'Debe seleccionar solo 5 imagenes',
                    'imagen_banner.*.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes',
                    'imagen_icono' => 'Debe de seleccionar el formato correcto de imagen',
                ];
                $validator = Validator::make($data, [
                    'nombre_propietario' => 'required',
                    'direccion' => 'required',
                    'rub_id' => 'required',
                    'celular' => 'required|size:8',
                    'celular_wp' => 'required|size:8',
                    'nombre_tienda' => 'required',
                    'actividad' => 'required',
                    'email' => 'required',
                    'imagen_banner' =>'required|min:1|max:5',
                    'imagen_banner.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000',
                    'imagen_icono' => 'required|mimes:jpeg,jpg,JPEG,JPG|max:2000',
                ], $messages);

                if ($validator->fails()) {
                    Toastr::warning('No se pudo guardar ningun cambio verifique los datos ingresados', "");
                    return back() ->withErrors($validator) ->withInput();
                }

                if ($request->hasFile('imagen_banner')) {
                    $files = $request->file('imagen_banner');
                     $data['imagen_banner'] = $this->armarListaImagenesBannerYGuardadoImaFisico($files,$xg,$yg,$ruta);
                     $data['alto_banner']  = $yg;
                     $data['ancho_banner'] = $xg;
                     $data['tipo_banner']  = $tipog;
                }

                if ($request->hasFile('imagen_icono')) {
                    $file2 = $request->imagen_icono;
                    $extencionImagen = $file2->extension();
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $nombreDos = time().''.uniqid().'.'.$extencionImagen;
                    $data['imagen_icono'] = $nombreUno;
                    $data['imagen_icono_dos'] = $nombreDos;
                    $imagenUno =Image::make($file2);
                    $imagenDos =Image::make($file2);
                    $imagenUno->resize($xp,$yp);
                    $imagenUno->save($ruta.$nombreUno,95);
                    $imagenDos->resize($xm,$ym);
                    $imagenDos->save($ruta.$nombreDos,95);
                    $data['alto_icono']  = $yp;
                    $data['ancho_icono'] = $xp;
                    $data['tipo_icono']  = $tipop;
                    $data['estado_icono'] = 'AC';
                    $data['alto_icono_dos']  = $xm;
                    $data['ancho_icono_dos'] = $ym;
                    $data['tipo_icono_dos']  = $tipom;
                }
                try {
                        $productor = $this->productorService->saveProductorAndImagenproductor($data);
                        $v_id = $data['usr_id'];

                        //logs
                        $audi = ['ip'=>$request->ip(),'tabla'=>'pro_productor','usuario'=>$user->id.'-'.$user->name,
                            'fecha'=>date('Y-m-d H:i:s'),'accion'=>'crear productor',
                            'datos'=>json_encode($data)];
                        $this->auditoriaService->save($audi);

                        if (empty($productor)) {
                            Toastr::warning('No se pudo guardar el productor', "");
                            return back()->withInput();
                        }else{
                            $re = $this->crearDeliveryPorDefecto($productor->pro_id);
                            Toastr::success('Operación completada ', "");
                            return redirect('productor/createeditproductor/'.$v_id);
                        }
                    } catch (Exception $e) {
                        Log::error($e->getMessage());
                        Toastr::error('Ocurrio un error al guardar el productor', "");
                        return back()->withInput();
                }
            }
        }else{
            $cantidadimagenesbannerhay = $data['cantidadimagenesbannerhay'];
            $limiteImagen = 5 - ($cantidadimagenesbannerhay);
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre_propietario.required' => 'El campo nombre es requerido',
                'direccion.required' => 'La direccion  es requerida ',
                'celular.required' => 'El campo celular es requerida',
                'celular_wp.required' => 'El campo celular whatsapp es requerida',
                'nombre_tienda.required' => 'El campo nombre tienda es requerido',
                'actividad.required' => 'El campo actividad es requerido',
                'email.required' => 'El campo email es requerido',
                'imagen_banner.max' => 'Debe seleccionar solo '.$limiteImagen.' imagenes',
                'imagen_banner.*.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes',
                'imagen_icono' => 'Debe de seleccionar el formato correcto de imagen',

            ];
            $validator = Validator::make($data, [
                'nombre_propietario' => 'required',
                'direccion' => 'required',
                'celular' => 'required|size:8',
                'celular_wp' => 'required|size:8',
                'nombre_tienda' => 'required',
                'actividad' => 'required',
                'email' => 'required',
                'imagen_icono' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000',
                'imagen_banner' =>'min:1|max:'.$limiteImagen,
                'imagen_banner.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000',
            ], $messages);
            if ($validator->fails()){
                Toastr::warning('No se pudo guardar ningun cambio verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('imagen_banner')) {
                $messages = [ 'imagen_banner.*.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes' ,
                              'imagen_banner.max' => 'Debe seleccionar solo '.$limiteImagen.' imagenes', ];
                $validator = Validator::make($data, ['imagen_banner' =>'min:1|max:'.$limiteImagen,
                                                    'imagen_banner.*' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique el formato o tamaño de la Imagen banner', "");
                    return back()->withErrors($validator)->withInput();
                }
                    $files = $request->file('imagen_banner');
                    $listaIma = null;
                    $i = 0;
                    foreach($files as $file) {
                        $extencionImagen = $file->extension();
                        $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                        if ($i==0) { $listaIma = $nombreUno; }else { $listaIma = $listaIma . ',' . $nombreUno; }
                        $i++;
                        $imagenUno =Image::make($file);
                        $imagenUno->resize($xg,$yg);
                        $imagenUno->save($ruta.$nombreUno,95);
                    }
                    $data['imagen_banner'] = $listaIma;
                    $data['alto_banner']  = $yg;
                    $data['ancho_banner'] = $xg;
                    $data['tipo_banner']  = $tipog;
            }

            if ($request->hasFile('imagen_icono')) {
                $messages = [ 'imagen_icono.max' => 'El peso de la imagen icono no debe ser mayor a 2000 kilobytes'  ];
                $validator = Validator::make($data, ['imagen_icono' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique el formato o tamaño de la imagen icono', "");
                    return back()->withErrors($validator)->withInput();
                }

                $file2 = $request->imagen_icono;
                $extencionImagen = $file2->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                $nombreDos = time().''.uniqid().'.'.$extencionImagen;
                $data['imagen_icono'] = $nombreUno;
                $data['imagen_icono_dos'] = $nombreDos;
                $imagenUno =Image::make($file2);
                $imagenDos =Image::make($file2);
                $imagenUno->resize($xp,$yp);
                $imagenUno->save($ruta.$nombreUno,95);
                $imagenDos->resize($xm,$ym);
                $imagenDos->save($ruta.$nombreDos,95);
                $data['alto_icono']  = $yp;
                $data['ancho_icono'] = $xp;
                $data['tipo_icono']  = $tipop;
                $data['alto_icono_dos']  = $ym;
                $data['ancho_icono_dos'] = $xm;
                $data['tipo_icono_dos']  = $tipom;
            }
                try {
                    $productor = $this->productorService->update($data);

                    //logs
                    $audi = ['ip'=>$request->ip(),'tabla'=>'pro_productor','usuario'=>$user->id.'-'.$user->name,
                        'fecha'=>date('Y-m-d H:i:s'),'accion'=>'actualizar datos del productor',
                        'datos'=>json_encode($data)];
                    $this->auditoriaService->save($audi);

                    if (empty($productor)){
                        Toastr::warning('No se pudo editar el productor', "");
                        return back()->withInput();
                    }else{
                        Toastr::success('Operación completada ', "");
                        return redirect('productor/createeditproductor/'.$request->usr_id);
                    }
                }catch (Exception $e){
                    Log::error($e->getMessage());
                    Toastr::error('Ocurrio un error al editar el productor', "");
                    return back()->withInput();
                }
        }
    }

    public function _eliminarimagen_icono(Request $request)
    {
        $imagenIcono = null;
        $ipd_id_icono = null;
        $productor = $this->productorService->getById($request->pro_id);
            foreach($productor->imagenProductores as $ImagenProductorIcono) {
                if($ImagenProductorIcono->tipo == 8 ){
                    $ImagenProductorIc = $this->imagenProductorService->getByIdImagenIcono($ImagenProductorIcono->ipd_id);
                    $ImagenProductorIc->estado = 'EL';
                    $ImagenProductorIc->save();
                }
                if($ImagenProductorIcono->tipo == 12 ){
                    $ImagenProductorIcon = $this->imagenProductorService->getByIdImagenIcono($ImagenProductorIcono->ipd_id);
                    $ImagenProductorIcon->estado = 'EL';
                    $ImagenProductorIcon->save();
                }
        }
        return view('productor._imagenproductoricono',compact('imagenIcono','ipd_id_icono'));
    }

    public function _eliminarimagenbanner(Request $request){
        $imagenProductor = ImagenProductor::where('ipd_id','=',$request->ipd_id)->first();
        $imagenProductor->estado= 'EL';
        $imagenProductor->save();
        $imagenesBanners = ImagenProductor::where([
            ['pro_id','=',$request->pro_id],
            ['tipo','=',1],
            ['estado','=','AC']
        ])->orderBy('pro_id','asc')->get();
        $cantidadimagenesbannerhay = count($imagenesBanners);
        $limiteImagen = 5 - $cantidadimagenesbannerhay;
        return view('productor._tablaimagenesproductorbanner',compact('imagenesBanners','cantidadimagenesbannerhay','limiteImagen'));
    }

    public function armarListaImagenesBannerYGuardadoImaFisico($files,$x,$y,$ruta){
        $pila = null;
        $i = 0;
        foreach($files as $file) {
            $extencionImagen = $file->extension();
            $nombreUno = time().''.uniqid().'.'.$extencionImagen;
            if ($i==0) {   $pila = $nombreUno;
            }else {   $pila = $pila . ',' . $nombreUno; }
            $i++;
            $imagenUno =Image::make($file);
            $imagenUno->resize($x,$y);
            $imagenUno->save($ruta.$nombreUno,95);
        }
        return $pila;
    }

    public function crearDeliveryPorDefecto($pro_id)
    {
        $data = array();
        $data['razon_social'] = 'Sin delivery';
        $data['propietario']='ninguno';
        $data['costo_minimo']=0;
        $data['costo_maximo']=0;
        $data['tipo_transporte']='Otros';
        $data['disponible'] = 1;
        $data['estado'] = 'AC';
        $data['pro_id'] = $pro_id;
        try {
            $delivery = $this->deliveryService->save($data);
            Toastr::success('Se creo un delivery por defecto',"");
            return $delivery;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->withInput();
        }
    }

    //TIENDA DEL PRODUCTOR
    public function tienda($pro_id)
    {
        $productor = $this->productorService->getByIdWithValoracionesAndImagenesAndProductos($pro_id);
        if ($productor->estado_tienda == 'EL' || $productor->estado == 'EL'){
            Toastr::warning('La tienda ya no esta disponible, disculpe las molestias.', "");
            return redirect('/');
        }
        $productos = $this->productoService->getAllProductosByProductorOrdenados($pro_id);
        $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
        $diasNuevos = $diasParametrica->valor1;
        $param = $this->parametricaService->getParametricaByTipoAndCodigo("ZOOM-PRODUCTOR-MAPA-1");
        $zoom = $param->valor1;
        $valoraciones = $this->valoracionProductorService->getValoracionesProductorByLimitSortByFechaDesc($pro_id,10);
        return view('productor.tienda',compact('productor','zoom','valoraciones','productos','diasNuevos'));
    }

    public function _guardarValoracion(Request $request)
    {
        $user = Auth::user();
        $data = array();
        $data['pro_id'] = $request->pro_id;
        $data['usr_id'] = $user->id;
        $data['puntuacion'] = $request->puntaje;
        $data['valoracion'] = $request->comentario;
        $data['fecha'] = date('Y-m-d H:i:s');
        $data['estado'] = 'AC';
        try {
            $valoracion = $this->valoracionProductorService->save($data);
            if (!empty($valoracion)){
                $valoraciones = $this->valoracionProductorService->getValoracionesProductorByLimitSortByFechaDesc($request->pro_id,10);
                $html = view('productor._valoraciones',compact('valoraciones'))->render();
                return response()->json([
                    'res' => true,
                    'html' => $html
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se pudo guardar la valoración'
                ]);
            }
        }catch (\Exception $e){
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'res' => false
            ]);
        }

    }
    //END TIENDA DEL PRODUCTOR

}
