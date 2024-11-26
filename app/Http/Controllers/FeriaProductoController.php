<?php
namespace App\Http\Controllers;
use App\Models\FeriaProductor;
use App\Models\FeriaProducto;
use App\Models\ImagenFeriaProducto;
use App\Models\ImagenProductor;
use App\Models\Productor;
use App\Services\AuditoriaService;
use App\Services\CorreoEnviadoService;
use App\Services\FeriaProductorService;
use App\Services\FeriaProductoService;
use App\Services\FeriaVirtualService;
use App\Services\ImagenFeriaProductoService;
use App\Services\ImagenFeriaVirtualService;
use App\Services\CategoriaRubroService;
use App\Services\ImagenProductoService;
use App\Services\ParametricaService;
use App\Services\ProductorService;
use App\Services\ProductoService;
use App\Services\RubroService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class FeriaProductoController extends Controller
{
    protected $feriaVirtualService;
    protected $rubroService;
    protected $parametricaService;
    protected $imagenFeriaVirtualService;
    protected $productorService;
    protected $correoEnviadoService;
    protected $userService;
    protected $feriaProductorService;
    protected $feriaProductoService;
    protected $categoriaRubroService;
    protected $productoService;
    protected $imagenProductoService;
    protected $imagenFeriaProductoService;
    protected $auditoriaService;
    public function __construct(
        FeriaVirtualService $feriaVirtualService,
        RubroService $rubroService,
        ParametricaService $parametricaService,
        ImagenFeriaVirtualService $imagenFeriaVirtualService,
        Productor $productor,
        ProductoService $productoService,
        ProductorService $productorService,
        CorreoEnviadoService $correoEnviadoService,
        UserService $userService,
        FeriaProductorService $feriaProductorService,
        FeriaProductoService $feriaProductoService,
        CategoriaRubroService $categoriaRubroService,
        ImagenProductoService $imagenProductoService,
        ImagenFeriaProductoService $imagenFeriaProductoService,
        AuditoriaService $auditoriaService
    )
    {
        $this->feriaVirtualService = $feriaVirtualService;
        $this->rubroService = $rubroService;
        $this->parametricaService = $parametricaService;
        $this->imagenFeriaVirtualService = $imagenFeriaVirtualService;
        $this->productor = $productor;
        $this->productorService = $productorService;
        $this->correoEnviadoService = $correoEnviadoService;
        $this->userService = $userService;
        $this->feriaProductorService = $feriaProductorService;
        $this->feriaProductoService = $feriaProductoService;
        $this->categoriaRubroService = $categoriaRubroService;
        $this->productoService = $productoService;
        $this->imagenProductoService = $imagenProductoService;
        $this->imagenFeriaProductoService = $imagenFeriaProductoService;
        $this->auditoriaService = $auditoriaService;
        $this->middleware('auth');
    }

    public function misferias($usr_id,Request $request)
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $titulo = "";
        if ($request->has('search')){
            $searchtype = $request->searchtype;
            $search = $request->search;
        }
        if ($request->has('sort')){
            $sort = $request->sort;
        }

        $productorexistente = $this->productorService->getProductorByUser($usr_id);
        if(empty($productorexistente)) {
            Toastr::warning('Por fabor registre sus datos de Productor !', "");
            return back()->withInput();
        }else{
            $lista = $this->feriaProductorService->getFeriaProductorByProductorPaginateBySearchAndSort(10,$productorexistente->pro_id,$searchtype,$search,$sort);
            foreach ($lista as $lis){
                $fechafin = $lis->feriaVirtual->fecha_final;
                $hoy  = date("Y-m-d");
                $date_1 = strtotime($hoy);
                $date_2 = strtotime($fechafin);
                if( $date_1 < $date_2){
                    $lis->comprobante = 'activo';
                }else{
                    $lis->comprobante = 'inactivo';
                }
            }
            return view('feriaproducto.misferias',compact('lista','usr_id','searchtype','search','sort'));
        }
    }


    public function index($pro_id,$fpd_id,Request $request)
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $titulo = "";
        if ($request->has('search')){
            $searchtype = $request->searchtype;
            $search = $request->search;
        }
        if ($request->has('sort')){
            $sort = $request->sort;
        }

        $lista = $this->feriaProductoService->getAllPaginateBySearchAndSortACAndEl(10,$fpd_id,$searchtype,$search,$sort);
        $fpd_id_modal = null;
        $pro_id_modal = null;
        $feriaProductor = $this->feriaProductorService->getById($fpd_id);
        $feriavirtual = $this->feriaVirtualService->getById($feriaProductor->fev_id);
        $titulo = $feriavirtual->nombre;
        return view('feriaproducto.index', compact('lista','pro_id','fpd_id_modal','pro_id_modal','titulo','fpd_id','searchtype','search','sort'));
    }


    public function create($pro_id,$fpd_id)
    {
        $productor = $this->productorService->getById($pro_id);
        $feriaProducto = new FeriaProducto();
        $listacategoria = $this->categoriaRubroService->cargarComboCategoriasByRubroHijos($productor->rub_id);
        $feriaProducto->fpr_id = 0;
        $feriaProducto->estado = 'AC';
        return view('feriaproducto.createedit',compact('feriaProducto','pro_id','listacategoria','fpd_id'));
    }

    public function edit($fpr_id,$pro_id,$fpd_id)
    {
        $feriaProducto= $this->feriaProductoService->getById($fpr_id);
        $cantidadimageneshay=null;

        $productor = $this->productorService->getById($pro_id);
        $listacategoria = $this->categoriaRubroService->cargarComboCategoriasByRubroHijos($productor->rub_id);
        $imagen_productos =  $this->imagenFeriaProductoService->getListaImagenFeriaProductoByProducto($fpr_id,8);
        $cantidadimageneshay = count($imagen_productos);
        $limiteImagen =  5 - $cantidadimageneshay;
        return view('feriaproducto.createedit',compact('feriaProducto','listacategoria','imagen_productos','cantidadimageneshay','limiteImagen','pro_id','fpd_id','fpr_id'));
    }

    public  function store(Request $request)
    {
        $user = Auth::user();
        $ruta = storage_path('app/public/uploads/');
        $data = $request->except('_token');
        $data['fecha_registro'] = date('Y-m-d');
        $tamImagenM = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-8");
        $tamImagenP = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-12");
        $maxCantiImagProducto= $this->parametricaService->getParametricaByTipoAndCodigo("MAX-PRODUCTO-IMAGEN");
        $maxCanImaPro = $maxCantiImagProducto->valor1;
        $xm=$tamImagenM->valor2;
        $ym=$tamImagenM->valor3;
        $tipom=$tamImagenM->valor1;
        $xp=$tamImagenP->valor2;
        $yp=$tamImagenP->valor3;
        $tipop=$tamImagenP->valor1;

        if ($request->fpr_id == 0) {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre_producto.required' => 'El campo nombre producto es requerido',
                'descripcion1.required' => 'El campo descripcion corta requerido',
                'descripcion2.required' => 'El campo descripcion larga  es requerido',
                'existencia_minima.required' => 'El campo existencia minima  es requerido',
                'precio.required' => 'El campo precio es requerido',
                'cat_id.required' => 'Debe de selecionar una categoria',
                'existencia.required' => 'El campo precio es requerido',
                'imagen_producto.max' => 'Debe seleccionar solo'.$maxCanImaPro.'imagenes',
                'imagen_producto.*.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes',
            ];
            $validator = Validator::make($data, [
                'nombre_producto' => 'required',
                'descripcion1' => 'required',
                'descripcion2' => 'required',
                'precio' => 'required',
                'cat_id' => 'required',
                'existencia_minima' => 'required',
                'existencia' => 'required',
                'imagen_producto' =>'required|min:1|max:'.$maxCanImaPro,
                'imagen_producto.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000',
            ], $messages);
            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            if ($request->hasFile('imagen_producto')) {
                $files = $request->file('imagen_producto');
                $listaImaM = null;
                $listaImaP = null;
                $i = 0;
                foreach($files as $file) {
                    $extencionImagen = $file->extension();
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $nombreDos = time().''.uniqid().'.'.$extencionImagen;
                    if ($i==0) {
                        $listaImaM = $nombreUno;
                        $listaImaP = $nombreDos;
                    }else {
                        $listaImaM = $listaImaM . ',' . $nombreUno;
                        $listaImaP = $listaImaP . ',' . $nombreDos;
                    }
                    $i++;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize($xm,$ym);
                    $imagenUno->save($ruta.$nombreUno,95);
                    $imagenUno =Image::make($file);
                    $imagenDos =Image::make($file);
                    $imagenUno->resize($xp,$yp);
                    $imagenUno->save($ruta.$nombreUno,95);
                    $imagenDos->resize($xm,$ym);
                    $imagenDos->save($ruta.$nombreDos,95);
                }
                $data['imagen_producto_m'] = $listaImaM;
                $data['alto_imagen_m']  = $ym;
                $data['ancho_imagen_m'] = $xm;
                $data['tipo_imagen_m']  = $tipom;
                $data['imagen_producto_p'] = $listaImaP;
                $data['alto_imagen_p']  = $yp;
                $data['ancho_imagen_p'] = $xp;
                $data['tipo_imagen_p']  = $tipop;
            }

            if ($request->hasFile('codigo_qr_venta_imagen')) {
                    $file2 = $request->codigo_qr_venta_imagen;
                    $extencionImagen = $file2->extension();
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $data['codigo_qr_venta'] = $nombreUno;
                    $imagenUno =Image::make($file2);
                    $imagenUno->resize($xp,$yp);
                    $imagenUno->save($ruta.$nombreUno,80);
                    $data['alto_icono']  = $yp;
                    $data['ancho_icono'] = $xp;
                    $data['tipo_icono']  = $tipop;
                    $data['estado_icono'] = 'AC';
                }
            try {
                $feriaProducto = $this->feriaProductoService->saveFeriaProductoAndImagenFeriaproducto($data);
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'fpr_feria_producto','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'registrar producto a feria',
                    'datos'=>json_encode($data)];
                $this->auditoriaService->save($audi);

                if (empty($feriaProducto)) {
                    Toastr::warning('No se pudo guardar la  producto feria', "");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada', "");
                    return redirect('feriaproducto/'.$data['pro_id'].'/'.$data['fpd_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar el producto feria', "");
                return back()->withInput();
            }
        }else{
            $cantidadimageneshay = $data['cantidadimageneshay'];
            $limiteImagen = $maxCanImaPro - ($cantidadimageneshay);

            $data['fecha_modificacion'] = date('Y-m-d');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre_producto.required' => 'El campo nombre producto es requerido',
                'descripcion1.required' => 'El campo descripcion corta requerido',
                'descripcion2.required' => 'El campo descripcion larga  es requerido',
                'existencia_minima.required' => 'El campo existencia minima  es requerido',
                'precio.required' => 'El campo precio es requerido',
                'cat_id.required' => 'Debe de selecionar una categoria',
                'existencia.required' => 'El campo precio es requerido',
                'imagen_producto.max' => 'Debe seleccionar solo '.$limiteImagen.' imagenes',
                'imagen_producto.*.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes',
            ];
            $validator = Validator::make($data, [
                'nombre_producto' => 'required',
                'descripcion1' => 'required',
                'descripcion2' => 'required',
                'precio' => 'required',
                'cat_id' => 'required',
                'existencia_minima' => 'required',
                'existencia' => 'required',
                'imagen_producto' =>'min:1|max:'.$limiteImagen,
                'imagen_producto.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000',
            ], $messages);
            if ($validator->fails()){
                Toastr::warning('No se pudo guardar ningun cambio verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('imagen_producto')) {
                $files = $request->file('imagen_producto');
                $listaImaM = null;
                $listaImaP = null;
                $i = 0;
                foreach($files as $file) {
                    $extencionImagen = $file->extension();
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $nombreDos = time().''.uniqid().'.'.$extencionImagen;
                    if ($i==0) {
                        $listaImaM = $nombreUno;
                        $listaImaP = $nombreDos;
                    }else {
                        $listaImaM = $listaImaM . ',' . $nombreUno;
                        $listaImaP = $listaImaP . ',' . $nombreDos;
                    }
                    $i++;
                    $imagenUno =Image::make($file);
                    $imagenUno->resize($xm,$ym);
                    $imagenUno->save($ruta.$nombreUno,95);
                    $imagenUno =Image::make($file);
                    $imagenDos =Image::make($file);
                    $imagenUno->resize($xp,$yp);
                    $imagenUno->save($ruta.$nombreUno,95);
                    $imagenDos->resize($xm,$ym);
                    $imagenDos->save($ruta.$nombreDos,95);
                }
                $data['imagen_producto_m'] = $listaImaM;
                $data['alto_imagen_m']  = $ym;
                $data['ancho_imagen_m'] = $xm;
                $data['tipo_imagen_m']  = $tipom;
                $data['imagen_producto_p'] = $listaImaP;
                $data['alto_imagen_p']  = $yp;
                $data['ancho_imagen_p'] = $xp;
                $data['tipo_imagen_p']  = $tipop;
            }
            if ($request->hasFile('codigo_qr_venta_imagen')) {
                    $file2 = $request->codigo_qr_venta_imagen;
                    $extencionImagen = $file2->extension();
                    $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                    $data['codigo_qr_venta'] = $nombreUno;
                    $imagenUno =Image::make($file2);
                    $imagenUno->resize($xp,$yp);
                    $imagenUno->save($ruta.$nombreUno,80);
                    $data['alto_icono']  = $yp;
                    $data['ancho_icono'] = $xp;
                    $data['tipo_icono']  = $tipop;
                    $data['estado_icono'] = 'AC';
            }
            try {
                $feriaProducto = $this->feriaProductoService->update($data);
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'fpr_feria_producto','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'actualizar registro de producto de feria',
                    'datos'=>json_encode($data)];
                $this->auditoriaService->save($audi);

                if (empty($feriaProducto)){
                    Toastr::warning('No se pudo editar el producto feria', "");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada ', "");
                    return redirect('feriaproducto/'.$data['pro_id'].'/'.$data['fpd_id'].'/lista');
                }
            }catch (Exception $e){
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar producto feria', "");
                return back()->withInput();
            }
        }
    }


    public function _modificarEstado(Request $request)
    {
        $user = Auth::user();
        $feriaProducto = $this->feriaProductoService->getById($request->fpr_id);
        if (!empty($feriaProducto)) {
            if($this->feriaProductoService->delete($feriaProducto,$request->texto)){
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'fpr_feria_producto','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'habilitar/inhabilitar producto de feria',
                    'datos'=>" fpr_id: $request->fpr_id, estado: $request->texto "];
                $this->auditoriaService->save($audi);

                return response()->json([
                    'res' => true
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se encontro la feria producto'
                ]);
            }
        }
        return response()->json([
            'res' => false,
            'mensaje' => 'No se encontro la feria producto'
        ]);
    }

    public function _eliminarimagen_producto(Request $request)
    {
        $user = Auth::user();
        $imagenesProducto = ImagenFeriaProducto::where([
            ['fpr_id','=',$request->fpr_id],
            ['numero_imagen','=',$request->numero_imagen]
        ])->get();

        foreach($imagenesProducto as $imagenProduc) {
            $imagenProducto = ImagenFeriaProducto::find($imagenProduc->ipf_id);
            $imagenProducto->estado = 'EL';
            $imagenProducto->save();
        }
        $imagen_productos = ImagenFeriaProducto::where([
            ['fpr_id','=',$request->fpr_id],
            ['tipo','=',8],
            ['estado','=','AC']
        ])->orderBy('fpr_id','asc')->get();
        $cantidadimageneshay = count($imagen_productos);
        $limiteImagen =  5 - $cantidadimageneshay;

        //logs
        $audi = ['ip'=>$request->ip(),'tabla'=>'fpr_feria_producto','usuario'=>$user->id.'-'.$user->name,
            'fecha'=>date('Y-m-d H:i:s'),'accion'=>'quitar imagen de producto de feria',
            'datos'=>" fpr_id: $request->fpr_id, numero_imagen: $request->numero_imagen "];
        $this->auditoriaService->save($audi);

        return view('feriaproducto._tablaimagenesferiaproducto',compact('imagen_productos','cantidadimageneshay','limiteImagen'));
    }

    /// ------------------------SELECCIONAR PRODUCTOS DE LA LISTA-------------------------------------------
    public function createlistaproductos($pro_id,$fpd_id)
    {
        //$listaProductos = $this->productoService->getAllProductosByProductorOrdenados($pro_id);
        $listaProductos = $this->productoService->getAllProductosByProductorOrdenadosQueNoEstenEnUnaFeriaProductor($pro_id,$fpd_id);

        return view('feriaproducto.listaproductoscheck',compact('listaProductos','fpd_id','pro_id'));
    }

    public function mandarlistacheck(Request $request)
    {
        $user = Auth::user();
        $modelo = $request->json()->all();
        $modelo = (object)$modelo;
        $fpd_id = $modelo->fpd_id;
        $cantidadimagenesbannerhay = count($modelo->datos);
        $cantidadimagenesbannerhay = $cantidadimagenesbannerhay-1;
        $feriaProducto = null;
        try {

        for($a=0; $a<=$cantidadimagenesbannerhay;$a++) {
            $decode = json_decode($modelo->datos[$a], true);
            $prd_id = $decode;
            $data = array();
            $producto = $this->productoService->getById($prd_id);
            $data['nombre_producto'] = $producto->nombre_producto;
            $data['existencia'] = $producto->existencia;
            $data['puntuacion'] = $producto->puntuacion;
            $data['descripcion1'] = $producto->descripcion1;
            $data['descripcion2'] = $producto->descripcion2;
            $data['precio'] = $producto->precio;
            $data['precio_oferta']= $producto->precio_oferta;
            $data['descuento']= $producto->descuento;
            $data['existencia_minima'] = $producto->existencia_minima;
            $data['fecha_registro'] = $producto->fecha_registro;
            $data['fecha_modificacion']= $producto->fecha_modificacion;
            $data['codigo_qr_venta']= $producto->codigo_qr_venta;
            $data['estado'] = $producto->estado;
            $data['cat_id'] = $producto->cat_id;
            $data['pro_id'] = $producto->pro_id;
            $data['prd_id'] = $producto->prd_id;// 'fecha_inicio_oferta', 'fecha_fin_oferta'
            $data['fpd_id'] = $fpd_id;
            $data['fecha_registro'] = date('Y-m-d');

            $listaImaM = null;
            $listaImaP = null;
            $imagenProductocopia = null;
            $imagen_productos_m =  $this->imagenProductoService->getListaImagenProductoByProducto($prd_id,8);
             $i = 0;
            foreach ($imagen_productos_m as $imagenProducto){
                $nombreUno = $imagenProducto->imagen;
                if ($i==0) {
                    $listaImaM = $nombreUno;
                }else {
                    $listaImaM = $listaImaM . ',' . $nombreUno;
                }
                $i++;
                $imagenProductocopia = $imagenProducto;
            }

            $data['imagen_producto_m'] = $listaImaM;
            $data['alto_imagen_m'] = $imagenProductocopia->alto;
            $data['ancho_imagen_m'] = $imagenProductocopia->ancho;
            $data['tipo_imagen_m'] = $imagenProductocopia->tipo;
            $data['numero_imagen'] = $imagenProductocopia->numero_imagen;
            $data['estado'] = $imagenProductocopia->estado;

            $imagenProductocopia_p = null;
            $imagen_productos_p =  $this->imagenProductoService->getListaImagenProductoByProducto($prd_id,12);
             $ii = 0;
            foreach ($imagen_productos_p as $imagenProducto){
                $nombreUno1 = $imagenProducto->imagen;
                if ($ii==0) {
                    $listaImaP = $nombreUno1;
                }else {
                    $listaImaP = $listaImaP . ',' . $nombreUno1;
                }
                $ii++;
                $imagenProductocopia_p = $imagenProducto;
            }
            $data['imagen_producto_p'] = $listaImaP;
            $data['alto_imagen_p']  = $imagenProductocopia_p->alto;
            $data['ancho_imagen_p'] = $imagenProductocopia_p->ancho;
            $data['tipo_imagen_p']  = $imagenProductocopia_p->tipo;
            $data['numero_imagen'] = $imagenProductocopia_p->numero_imagen;
            $data['estado'] = $imagenProductocopia_p->estado;

            $feriaProducto = $this->feriaProductoService->saveFeriaProductoAndImagenFeriaproducto($data);

        }

        $respuesta["pro_id"] = $data['pro_id'];
        $respuesta["fpd_id"] = $data['fpd_id'];
        $respuesta["res"] = true;

        //logs
        $audi = ['ip'=>$request->ip(),'tabla'=>'fpr_feria_producto','usuario'=>$user->id.'-'.$user->name,
            'fecha'=>date('Y-m-d H:i:s'),'accion'=>'registro producto de feria desde productos de su tienda',
            'datos'=>json_encode($modelo)];
        $this->auditoriaService->save($audi);

        return response()->json($respuesta);
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();
            return response()->json([
                'res' => false,
                'error' => $e->getMessage()
            ]);
        }


    }

    public function _obtenerlistaproductos(Request $request)
    {
        $pro_id = $request->pro_id;
        //$listaProductos = $this->productoService->getAllProductosByProductorOrdenados($pro_id);
        $listaProductos = $this->productoService->getAllProductosByProductorOrdenadosQueNoEstenEnUnaFeriaProductor($request->pro_id,$request->fpd_id);
        return view('feriaproducto._tablalistaproducto',compact('listaProductos'));
    }












}
