<?php
namespace App\Http\Controllers;
use App\Models\FeriaVirtual;
use App\Models\ImagenFeria;
use App\Services\AuditoriaService;
use App\Services\FeriaProductoService;
use App\Services\FeriaVirtualService;
use App\Services\ImagenFeriaProductoService;
use App\Services\ImagenFeriaVirtualService;
use App\Models\Productor;
use App\Services\ParametricaService;
use App\Services\RubroService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class FeriaVirtualController extends Controller
{
    protected $feriaVirtualService;
    protected $rubroService;
    protected $parametricaService;
    protected $imagenFeriaVirtualService;
    protected $productorService;
    protected $feriaProductoService;
    protected $imagenFeriaProductoService;
    protected $auditoriaService;
    public function __construct(
        FeriaVirtualService $feriaVirtualService,
        RubroService $rubroService,
        ParametricaService $parametricaService,
        ImagenFeriaVirtualService $imagenFeriaVirtualService,
        Productor $productor,
        FeriaProductoService $feriaProductoService,
        ImagenFeriaProductoService $imagenFeriaProductoService,
        AuditoriaService $auditoriaService
    )
    {
        $this->feriaVirtualService = $feriaVirtualService;
        $this->rubroService = $rubroService;
        $this->parametricaService = $parametricaService;
        $this->imagenFeriaVirtualService = $imagenFeriaVirtualService;
        $this->productor = $productor;
        $this->feriaProductoService = $feriaProductoService;
        $this->imagenFeriaProductoService = $imagenFeriaProductoService;
        $this->auditoriaService = $auditoriaService;
    }

    public function index(Request $request)
    {
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
        $lista = $this->feriaVirtualService->getAllPaginateBySearchAndSortACAndEl(10,$searchtype,$search,$sort);
        $listaProductores = $this->productor->all();
        return view('feriavirtual.index',compact('lista','searchtype','search','sort','listaProductores'));
    }

    public function create()
    {
        $param = $this->parametricaService->getParametricaByTipoAndCodigo("ZOOM-PRODUCTOR-MAPA-1");
        $feriavirtual = new FeriaVirtual();
        $feriavirtual->fev_id = 0;
        $feriavirtual->estado = 'AC';
        $listarubro = $this->rubroService->getComboRubros();
        $feriavirtual->latitud = $param->valor2;
        $feriavirtual->longitud = $param->valor3;
        return view('feriavirtual.createedit',compact('feriavirtual','listarubro'));
    }

    public function edit($fev_id)
    {
        $imagen_afiche = null;
        $ife_id_afiche = 0;
        $listarubro = $this->rubroService->getComboRubros();
        $feriavirtual = $this->feriaVirtualService->getById($fev_id);
        $cantidadimagenesbannerhay=null;
        $imagenesBanners = $this->imagenFeriaVirtualService->getListaImagenFeriaVirtualByFeriaVirtual($fev_id,1);
        $cantidadimagenesbannerhay = count($imagenesBanners);

        foreach($feriavirtual->imagenFerias as $nuevaImagenFeria) {
            if($nuevaImagenFeria->tipo == 20 ){
                $imagen_afiche = $nuevaImagenFeria->imagen;
                $ife_id_afiche = $nuevaImagenFeria->ife_id;
            }
        }

        return view('feriavirtual.createedit',compact('fev_id','feriavirtual','listarubro','cantidadimagenesbannerhay','imagenesBanners','imagen_afiche','ife_id_afiche'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        $tamImagenbanner = $this->parametricaService->getParametricaByTipoAndCodigo('TIPO-IMAGEN_1');
        $tamImagenAfiche = $this->parametricaService->getParametricaByTipoAndCodigo('TIPO-IMAGEN-20');
        $maxCantiImagAfiche= $this->parametricaService->getParametricaByTipoAndCodigo("MAX-PRODUCTO-IMAGEN");
        $maxCanImaPro = $maxCantiImagAfiche->valor1;
        $xban = $tamImagenbanner->valor2;
        $yban = $tamImagenbanner->valor3;
        $xafi = $tamImagenAfiche->valor2;
        $yafi = $tamImagenAfiche->valor3;
        if($request->fev_id == 0 ) {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'fecha_inicio.required' => 'El campo fecha inicio es requerido',
                'fecha_final.required' => 'El campo fecha fin es requerido',
                'lugar.required' => 'El campo lugar es requerido',
                'direccion.required' => 'El campo direccion es requerido',
                'imagen_banner.max' => 'Debe seleccionar solo ' . $maxCanImaPro . ' imagenes',
                'imagen_banner.*.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes',
                'imagen_afiche' => 'Debe de seleccionar el formato correcto de imagen'
            ];

            $validator = Validator::make($data, [
                'nombre' => 'required',
                'descripcion' => 'required',
                'fecha_inicio' => 'required',
                'fecha_final' => 'required',
                'lugar' => 'required',
                'direccion' => 'required',
                'imagen_banner' => 'min:1|max:'. $maxCanImaPro,
                'imagen_banner.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000',
                'imagen_afiche' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000'
            ], $messages);

            if ($validator->fails()) {
                 Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            if ($request->hasFile('imagen_banner')) {
                $files = $request->file('imagen_banner');
                $pila = null;
                $i = 0;
                foreach($files as $file) {
                    $extencionImagen = $file->extension();
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    if ($i==0) {  $pila = $nombreUno;
                    }else {   $pila = $pila . ',' . $nombreUno; }
                    $i++;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize($xban,$yban);
                    $imagenUno->save($ruta.$nombreUno,95);
                }
                $data['imagen_banner'] = $pila;
                $data['ancho_banner'] = $xban;
                $data['alto_banner']  = $yban;
                $data['tipo_banner']  = $tamImagenbanner->valor1;
            }

            if ($request->hasFile('imagen_afiche')) {
                $file2 = $request->imagen_afiche;
                $extencionImagen2 =$file2->extension();
                $nombreIcono = time().''.uniqid().'.'.$extencionImagen2;
                $data['imagen_afiche'] = $nombreIcono;
                $imagenIcono =Image::make($file2);
                $imagenIcono->resize($tamImagenAfiche->valor2,$tamImagenAfiche->valor3);
                $imagenIcono->save($ruta.$nombreIcono,95);
                $data['alto_afiche']  = $yafi;
                $data['ancho_afiche'] = $xafi;
                $data['tipo_afiche']  = $tamImagenAfiche->valor1;
            }
            $date_2 = $this->fechaConvertida($data['fecha_inicio']);
            $date_3 = $this->fechaConvertida($data['fecha_final']);
            $hoy  = date("Y-m-d");
            $date_1 = strtotime($hoy);

            if($date_2 > $date_1){
                if($date_3 >= $date_2){
                    try {

                        $fecha_a = $data['fecha_inicio'];
                        $fecha_a = str_replace('/','-',$fecha_a);
                        $data['fecha_inicio'] = date('Y-m-d', strtotime($fecha_a));
                        $fecha_b = $data['fecha_final'];
                        $fecha_b = str_replace('/','-',$fecha_b);
                        $data['fecha_final'] = date('Y-m-d', strtotime($fecha_b));

                        $feriavirtual = $this->feriaVirtualService->save($data);
                        //logs
                        $audi = ['ip'=>$request->ip(),'tabla'=>'fev_feria_virtual','usuario'=>$user->id.'-'.$user->name,
                            'fecha'=>date('Y-m-d H:i:s'),'accion'=>'registrar feria virtual',
                            'datos'=>json_encode($data)];
                        $this->auditoriaService->save($audi);

                        if (empty($feriavirtual)) {
                            Toastr::warning('No se pudo guardar la feria virtual', "");
                            return redirect('feriavirtual');
                        }else{
                            Toastr::success('Operación completada ', "");
                            return redirect('feriavirtual');
                        }

                    } catch (Exception $e) {
                        Log::error($e->getMessage());
                        Toastr::error('Ocurrio un error al guardar la feria virtual', "");
                        return back()->withInput();
                    }
                }else{
                    Toastr::warning('La Fecha de Fin .Debe de ser menor o igual a la fecha Inicio ', "");
                    return back()->withInput();
                }
            }else{
                Toastr::warning('La Fecha de Inicio .Debe de ser mayor a la Fecha de Hoy ', "");
                return back()->withInput();
            }
        }else {

            $cantidadimagenesbannerhay = $data['cantidadimagenesbannerhay'];
            $limiteImagen = $maxCanImaPro - ($cantidadimagenesbannerhay);
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'fecha_inicio.required' => 'El campo fecha inicio es requerido',
                'fecha_final.required' => 'El campo fecha fin es requerido',
                'lugar.required' => 'El campo lugar es requerido',
                'direccion.required' => 'El campo direccion es requerido',
                'imagen_banner.max' => 'Debe seleccionar solo ' . $limiteImagen . ' imagenes',
                'imagen_banner.*.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes',
                'imagen_afiche' => 'Debe de seleccionar el formato correcto de imagen'
            ];

            $validator = Validator::make($data, [
                'nombre' => 'required',
                'descripcion' => 'required',
                'fecha_inicio' => 'required',
                'fecha_final' => 'required',
                'lugar' => 'required',
                'direccion' => 'required',
                'imagen_banner' => 'min:1|max:'.$limiteImagen,
                'imagen_banner.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000',
                'imagen_afiche' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('imagen_banner')) {
                $files = $request->file('imagen_banner');
                $pila = null;
                $i = 0;
                foreach ($files as $file) {
                    $extencionImagen = $file->extension();
                    $nombreUno = time() . '' . uniqid() . '.' . $extencionImagen;
                    if ($i == 0) {
                        $pila = $nombreUno;
                    } else {
                        $pila = $pila . ',' . $nombreUno;
                    }
                    $i++;
                    $imagenUno = Image::make($file);
                    $imagenUno->resize($tamImagenbanner->valor2, $tamImagenbanner->valor3);
                    $imagenUno->save($ruta . $nombreUno, 95);
                }
                $data['imagen_banner'] = $pila;
                $data['ancho_banner'] = $tamImagenbanner->valor2;
                $data['alto_banner'] = $tamImagenbanner->valor3;
                $data['tipo_banner'] = $tamImagenbanner->valor1;
            }

            if ($request->hasFile('imagen_afiche')) {
                $file2 = $request->imagen_afiche;
                $extencionImagen2 = $file2->extension();
                $nombreIcono2 = time() . '' . uniqid() . '.' . $extencionImagen2;
                $data['imagen_afiche'] = $nombreIcono2;
                $imagenIcono = Image::make($file2);
                $imagenIcono->resize($tamImagenAfiche->valor2, $tamImagenAfiche->valor3);
                $imagenIcono->save($ruta . $nombreIcono2, 95);
                $data['alto_afiche'] = $tamImagenAfiche->valor3;
                $data['ancho_afiche'] = $tamImagenAfiche->valor2;
                $data['tipo_afiche'] = $tamImagenAfiche->valor1;
            }

            $date_2 = $this->fechaConvertida($data['fecha_inicio']);
            $date_3 = $this->fechaConvertida($data['fecha_final']);
            $hoy  = date("Y-m-d");
            $date_1 = strtotime($hoy);
            //if($date_2 > $date_1){
                if($date_3 >= $date_2){
                    try {

                        $fecha_a = $data['fecha_inicio'];
                        $fecha_a = str_replace('/','-',$fecha_a);
                        $data['fecha_inicio'] = date('Y-m-d', strtotime($fecha_a));
                        $fecha_b = $data['fecha_final'];
                        $fecha_b = str_replace('/','-',$fecha_b);
                        $data['fecha_final'] = date('Y-m-d', strtotime($fecha_b));
                        $feriavirtual = $this->feriaVirtualService->update($data);
                        //logs
                        $audi = ['ip'=>$request->ip(),'tabla'=>'fev_feria_virtual','usuario'=>$user->id.'-'.$user->name,
                            'fecha'=>date('Y-m-d H:i:s'),'accion'=>'actualizar feria virtual',
                            'datos'=>json_encode($data)];
                        $this->auditoriaService->save($audi);

                        if (empty($feriavirtual)) {
                            Toastr::warning('No se pudo editar la feria virtual', "");
                            return redirect('feriavirtual');
                        }else{
                            Toastr::success('Operación completada ', "");
                            return redirect('feriavirtual');
                        }
                    } catch (Exception $e) {
                        Log::error($e->getMessage());
                        Toastr::error('Ocurrio un error al editar la feria virtual', "");

                        return back()->withInput();
                    }
                }else{
                    Toastr::warning('La Fecha de Fin .Debe de ser menor o igual a la fecha Inicio ', "");
                    return back()->withInput();
                }
            //}else{
            //    Toastr::warning('La Fecha de Inicio .Debe de ser mayor a la Fecha de Hoy ', "");
            //    return back()->withInput();
            //}

        }
    }

    public function fechaConvertida($fecha)
    {
        $mesanio = explode("/", $fecha);
        $dia1 = $mesanio[0];
        $mes1 = $mesanio[1];
        $anio1 = $mesanio[2];
        $fecha_v = $anio1.'-'.$mes1.'-'.$dia1;
        $date = strtotime($fecha_v);
        return $date;
    }

    public function _modificarEstado(Request $request)
    {
        $user = Auth::user();
        $feriaVirtual = $this->feriaVirtualService->getById($request->fev_id);
        if (!empty($feriaVirtual)) {
            if($this->feriaVirtualService->delete($feriaVirtual,$request->texto)){
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'fev_feria_virtual','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'habilitar/inhabilitar feria virtual',
                    'datos'=>" fev_id: $request->fev_id, estado: $request->texto "];
                $this->auditoriaService->save($audi);

                return response()->json([
                    'res' => true
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se encontro la feria virtual'
                ]);
            }
        }
        return response()->json([
            'res' => false,
            'mensaje' => 'No se encontro la feria virtual'
        ]);
    }

    public function _eliminarimagenbanner(Request $request){
        $imagenFeria = ImagenFeria::where('ife_id','=',$request->ife_id)->first();
        $imagenFeria->estado= 'EL';
        $imagenFeria->save();
        $imagenesBanners = ImagenFeria::where([
            ['fev_id','=',$request->fev_id],
            ['tipo','=',1],
            ['estado','=','AC']
        ])->orderBy('ife_id','asc')->get();
        $cantidadimagenesbannerhay = count($imagenesBanners);

        return view('feriavirtual._tablaimagenesferiavirtualbanner',compact('imagenesBanners','cantidadimagenesbannerhay'));
    }

    //VISTA DE FERIAS PARA EL PUBLICO

    public function lista(Request $request)
    {
        $sort = 3;
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $ferias = $this->feriaVirtualService->getAllAcAndPaginateAndSort(10,$sort);
        return view('feriavirtual.lista',compact('ferias','sort'));
    }

    public function ver($fev_id)
    {
        $feria = $this->feriaVirtualService->getById($fev_id);
        $param = $this->parametricaService->getParametricaByTipoAndCodigo("ZOOM-PRODUCTOR-MAPA-1");
        $zoom = $param->valor1;
        $fechaActual = date('Y-m-d');
        $productos = new Collection();
        if($fechaActual <= $feria->fecha_final){
            $productos = $this->feriaVirtualService->getAllProductosFeriasAcAndTiendaAcByFeriaAndOrden($fev_id);
        }
        return view('feriavirtual.ver',compact('feria','zoom','productos'));
    }

    public function verproducto($fpr_id)
    {
        $user = null;
        if(Auth::check()){
            $user = Auth::user();
        }else{
            $user = null;
        }

        $feria = null;
        $producto = $this->feriaProductoService->getById($fpr_id);
        if (!empty($producto)){
            $feria = $this->feriaVirtualService->getById($producto->feriaProductor->fev_id);
        }

        //control para el producto, si el producto o productor estan anulados se redirige a la vista inicial con un mensaje
        if ($producto->estado == 'EL'){
            Toastr::warning('El producto ya no esta disponible, disculpe las molestias.', "");
            return redirect('/');
        }
        if ($producto->productor->estado_tienda == 'EL'){
            Toastr::warning('El producto ya no esta disponible, disculpe las molestias.', "");
            return redirect('/');
        }

        $imagenes = $this->imagenFeriaProductoService->getAllImagenesAcMatrizByFeriaProducto($fpr_id);
        $precioUnidadFinal = $producto->precio;

        $valoraciones = new Collection();
        //dd($producto);

        //revisar si se puede vender por whatsapp
        $telefonoWhatsapp = null;
        if(isset($producto->productor->celular_wp)){
            $telefonoWhatsapp = $producto->productor->celular_wp;
        }
        //revisar si se puede vender por facebook
        $paginaFacebook = null;
        $linkPaginaFacebook = null;
        if(isset($producto->productor->link_facebook)){
            $linkPaginaFacebook = $producto->productor->link_facebook;
            $link = $producto->productor->link_facebook;
            $arrayLink = explode('/',$link);
            $cantidad = count($arrayLink);
            $cantidad--;
            if ($cantidad > 0){
                while ($cantidad > 0){
                    $paginaFacebook = $arrayLink[$cantidad];
                    if ($paginaFacebook != ''){
                        $paginaFacebook = $arrayLink[$cantidad];
                        break;
                    }
                    $cantidad--;
                }
            }
        }

        return view('feriavirtual.verproducto',
            compact(
                'user',
                'producto',
                'imagenes',
                'precioUnidadFinal',
                'valoraciones',
                'telefonoWhatsapp',
                'linkPaginaFacebook',
                'paginaFacebook',
                'feria'
            ));


    }
    //END VISTA DE FERIAS PARA EL PUBLICO


}
