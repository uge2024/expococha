<?php
namespace App\Http\Controllers;

use App\Models\ImagenProducto;
use App\Models\Producto;
use App\Services\AuditoriaService;
use App\Services\CategoriaRubroService;
use App\Services\ImagenProductoService;
use App\Services\ParametricaService;
use App\Services\ProductorService;
use App\Services\ProductoService;
use App\Services\RubroService;
use App\Services\ValoracionProductoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;
use DateTime;

class ProductoController extends Controller
{
    private $productorService;
    private $productoService;
    private $categoriaRubroService;
    private $parametricaService;
    private $imagenProductoService;
    protected $rubroService;
    protected $valoracionProductoService;
    protected $auditoriaService;
    public function __construct(
        ProductorService $productorService,
        ProductoService $productoService,
        CategoriaRubroService $categoriaRubroService,
        ParametricaService $parametricaService,
        ImagenProductoService $imagenProductoService,
        RubroService $rubroService,
        ValoracionProductoService $valoracionProductoService,
        AuditoriaService $auditoriaService
    )
    {
        $this->productorService = $productorService;
        $this->productoService = $productoService;
        $this->categoriaRubroService = $categoriaRubroService;
        $this->parametricaService = $parametricaService;
        $this->imagenProductoService = $imagenProductoService;
        $this->rubroService = $rubroService;
        $this->valoracionProductoService = $valoracionProductoService;
        $this->auditoriaService = $auditoriaService;
    }

    public function index($usr_id,Request $request)
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
            $titulo = $productorexistente->nombre_tienda;
            $pro_id = $productorexistente->pro_id;
            $lista = new Producto();
            $lista = $this->productoService->getAllPaginateBySearchAndSortACAndEl(10,$pro_id,$searchtype,$search,$sort);
            return view('producto.index', compact('lista', 'titulo', 'pro_id','searchtype','search','sort','usr_id'));
        }
    }

    public function create($pro_id,$usr_id)//id productor
    {
        $productor = $this->productorService->getById($pro_id);
        $producto = new Producto();
        $listacategoria = $this->categoriaRubroService->cargarComboCategoriasByRubroHijos($productor->rub_id);
        $producto->prd_id = 0;
        $producto->estado = 'AC';
        return view('producto.createedit',compact('producto','pro_id','listacategoria','usr_id'));
    }

    public function edit($prd_id,$pro_id,$usr_id)
    {
        $cantidadimageneshay=null;
        $productor = $this->productorService->getById($pro_id);
        $producto = $this->productoService->getById($prd_id);
        $listacategoria = $this->categoriaRubroService->cargarComboCategoriasByRubroHijos($productor->rub_id);
        $imagen_productos =  $this->imagenProductoService->getListaImagenProductoByProducto($prd_id,8);
        $cantidadimageneshay = count($imagen_productos);
        $limiteImagen =  5 - $cantidadimageneshay;
        return view('producto.createedit',compact('producto','listacategoria','usr_id','pro_id','imagen_productos','cantidadimageneshay','prd_id','limiteImagen'));
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
        if ($request->prd_id == 0) {
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
                $producto = $this->productoService->saveProductoAndImagenproducto($data);
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'prd_producto','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'crear producto',
                    'datos'=>json_encode($data)];
                $this->auditoriaService->save($audi);

                if (empty($producto)) {
                    Toastr::warning('No se pudo guardar el producto', "");
                }else{
                    Toastr::success('Operación completada', "");
                    return redirect('producto/'.$data['usr_id'].'/lista');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar el producto', "");
                return back()->withInput();
            }
        } else {
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
                $messages = [ 'imagen_producto.*.max' => 'El peso de la imagen producto no debe ser mayor a 2000 kilobytes' ,
                              'imagen_producto.max' => 'Debe seleccionar solo '.$limiteImagen.' imagenes', ];
                $validator = Validator::make($data, ['imagen_producto' =>'min:1|max:'.$limiteImagen,
                                                    'imagen_producto.*' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique el formato o tamaño de la Imagen banner', "");
                    return back()->withErrors($validator)->withInput();
                }
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
                $messages = [ 'codigo_qr_venta_imagen.max' => 'El peso de la imagen icono no debe ser mayor a 2000 kilobytes'  ];
                $validator = Validator::make($data, ['codigo_qr_venta_imagen' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique el formato o tamaño del codigo qr', "");
                    return back()->withErrors($validator)->withInput();
                }
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
                $producto = $this->productoService->update($data);
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'prd_producto','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'actualizar producto',
                    'datos'=>json_encode($data)];
                $this->auditoriaService->save($audi);

                if (empty($producto)){
                    Toastr::warning('No se pudo editar el producto', "");
                }else{
                    Toastr::success('Operación completada ', "");
                    return redirect('producto/'.$data['usr_id'].'/lista');
                }
            }catch (Exception $e){
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar el producto', "");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        $user = Auth::user();
        $producto = $this->productoService->getById($request->prd_id);
        if (!empty($producto)) {
            if($this->productoService->delete($producto,$request->texto)){
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'prd_producto','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'habilitar/inhabilitar producto',
                    'datos'=>" prd_id: $request->prd_id, estado: $request->texto "];
                $this->auditoriaService->save($audi);

                return response()->json([
                    'res' => true
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se encontro el Producto'
                ]);
            }
        }
        return response()->json([
            'res' => false,
            'mensaje' => 'No se encontro el Producto'
        ]);
    }

    public function _eliminarimagen_producto(Request $request)
    {
        $user = Auth::user();
        $imagenesProducto = ImagenProducto::where([
            ['prd_id','=',$request->prd_id],
            ['numero_imagen','=',$request->numero_imagen]
        ])->get();

        foreach($imagenesProducto as $imagenProduc) {
          $imagenProducto = ImagenProducto::find($imagenProduc->ipd_id);
          $imagenProducto->estado = 'EL';
          $imagenProducto->save();
        }

        $imagen_productos = ImagenProducto::where([
            ['prd_id','=',$request->prd_id],
            ['tipo','=',8],
            ['estado','=','AC']
        ])->orderBy('prd_id','asc')->get();
        $cantidadimageneshay = count($imagen_productos);
        $limiteImagen =  5 - $cantidadimageneshay;

        //logs
        $audi = ['ip'=>$request->ip(),'tabla'=>'prd_producto','usuario'=>$user->id.'-'.$user->name,
            'fecha'=>date('Y-m-d H:i:s'),'accion'=>'quitar imagen producto',
            'datos'=>" prd_id: $request->prd_id, numero_imagen: $request->numero_imagen "];
        $this->auditoriaService->save($audi);

        return view('producto._tablaimagenesproducto',compact('imagen_productos','cantidadimageneshay','limiteImagen'));
    }

    public function registro_oferta_crear($prd_id,$usr_id)//id productor
    {
        $producto = $this->productoService->getById($prd_id);
        $pro_id = $producto->pro_id;
        return view('producto.registrooferta',compact('producto','pro_id','usr_id'));
    }


    public function registrooferta(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'precio_oferta.required' => 'El campo precio oferta es requerido',
                'fecha_inicio_oferta.required' => 'El campo fecha inicio oferta es requerido',
                'fecha_fin_oferta.required' => 'El campo fecha fin oferta es requerido',
            ];
            $validator = Validator::make($data, [
                'precio_oferta' => 'required',
                'fecha_inicio_oferta' => 'required',
                'fecha_fin_oferta' => 'required',
            ], $messages);
            if ($validator->fails()){
                Toastr::warning('No se pudo guardar ningun cambio verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            $precio = $data['precio'];   $precio_oferta = $data['precio_oferta'];
            $fecha_inicio_oferta = $data['fecha_inicio_oferta'];
            $fecha_fin_oferta    = $data['fecha_fin_oferta'];
            $mesanio = explode("/", $fecha_inicio_oferta);
            $dia1 = $mesanio[0]; $mes1 = $mesanio[1]; $anio1 = $mesanio[2]; $fec_a = $anio1.'-'.$mes1.'-'.$dia1;
            $mesanio = explode("/", $fecha_fin_oferta);
            $dia = $mesanio[0]; $mes = $mesanio[1]; $anio = $mesanio[2]; $fec_b = $anio.'-'.$mes.'-'.$dia;

            $date_2 = strtotime($fec_a);
            $date_3 = strtotime($fec_b);
            $hoy  = date("Y-m-d");
            $date_1 = strtotime($hoy);
            if($precio_oferta>0){
                if($precio > $precio_oferta){
                    if( $date_2 > $date_1  ){
                        if($date_3 >= $date_2){
                            $descuento = (100*$precio_oferta)/$precio;
                            $valor = ceil($descuento);
                            $valorfinal = 100-$valor;
                            $data['descuento'] = intval($valorfinal);
                               try {
                                    //$data['fecha_inicio_oferta'] = $dia1.'/'.$mes1.'/'.$anio1;
                                    //$data['fecha_fin_oferta'] = $dia.'-'.$mes.'-'.$anio;
                                    $data['fecha_inicio_oferta'] = $anio1.'-'.$mes1.'-'.$dia1;
                                    $data['fecha_fin_oferta'] = $anio.'-'.$mes.'-'.$dia;
                                    $producto = $this->productoService->agregarOferta($data);

                                   //logs
                                   $audi = ['ip'=>$request->ip(),'tabla'=>'prd_producto','usuario'=>$user->id.'-'.$user->name,
                                       'fecha'=>date('Y-m-d H:i:s'),'accion'=>'registrar oferta',
                                       'datos'=>json_encode($data)];
                                   $this->auditoriaService->save($audi);

                                    if (empty($producto)){
                                        Toastr::warning('No se pudo guardar el registro oferta', "");
                                    }
                                    Toastr::success('Operación completada ', "");
                                    return redirect('producto/'.$data['usr_id'].'/lista');
                                }catch (Exception $e){
                                    Log::error($e->getMessage());
                                    Toastr::error('Ocurrio un error al crear registro oferta', "");
                                    return back()->withInput();
                                }
                        }else{
                            Toastr::warning('La fecha de fin .Debe de ser menor a la fecha inicio ', "");
                            return back()->withInput();
                        }
                    }else{
                        Toastr::warning('La fecha de inicio .Debe de ser mayor a la fecha de hoy ', "");
                        return back()->withInput();
                    }
                }else{
                        Toastr::warning('El precio oferta debe de ser menor al precio del producto', "");
                        return back()->withInput();
                }
            }else{
                Toastr::warning('El precio debe de ser mayor a 0', "");
                return back()->withInput();
            }
    }

    public function _eliminarimagen_qr(Request $request)
    {
        $producto = $this->productoService->getById($request->prd_id);
        $producto->codigo_qr_venta = null;
        $producto->save();
        $codigo_qr_venta = null;
        return view('producto._imagenproductoqr',compact('codigo_qr_venta'));
    }

    //Vistas de productos para clientes
    public function todos(Request $request)
    {
        $sort = 1;
        $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
        $diasNuevos = $diasParametrica->valor1;
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $productos = $this->productoService->getAllProductosBySortAndPaginate($sort,12);
        return view('producto.todos',compact('productos','sort','diasNuevos'));
    }

    public function ofertas(Request $request)
    {
        $sort = 1;
        $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
        $diasNuevos = $diasParametrica->valor1;
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $productos = $this->productoService->getAllProductosOfertasBySortAndPaginate($sort,12);
        return view('producto.ofertas',compact('productos','sort','diasNuevos'));
    }

    public function nuevos(Request $request)
    {
        $sort = 1;
        $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
        $diasNuevos = $diasParametrica->valor1;
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $productos = $this->productoService->getAllProductosNuevosBySortAndPaginate($sort,12,$diasNuevos);
        return view('producto.nuevos',compact('productos','sort','diasNuevos'));
    }

    public function rubros($rub_id,Request $request)
    {
        $rubro = $this->rubroService->getById($rub_id);
        $sort = 1;
        $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
        $diasNuevos = $diasParametrica->valor1;
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $productos = $this->productoService->getAllProductosByRubroSortAndPaginate($sort,12,$rub_id);
        return view('producto.rubros',compact('productos','sort','diasNuevos','rubro'));
    }

    public function categorias($cat_id,Request $request)
    {
        $categoria = $this->categoriaRubroService->getById($cat_id);
        $sort = 1;
        $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
        $diasNuevos = $diasParametrica->valor1;
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $productos = $this->productoService->getAllProductosByCategoriaSortAndPaginate($sort,12,$cat_id);
        return view('producto.categorias',compact('productos','sort','diasNuevos','categoria'));
    }

    public function ver($prd_id)
    {
        $user = null;
        if(Auth::check()){
            $user = Auth::user();
        }else{
            $user = null;
        }
        $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
        $diasNuevos = $diasParametrica->valor1;
        $producto = $this->productoService->getById($prd_id);

        //control para el producto, si el producto o productor estan anulados se redirige a la vista inicial con un mensaje
        if ($producto->estado == 'EL'){
            Toastr::warning('El producto ya no esta disponible, disculpe las molestias.', "");
            return redirect('/');
        }
        if ($producto->productor->estado_tienda == 'EL'){
            Toastr::warning('El producto ya no esta disponible, disculpe las molestias.', "");
            return redirect('/');
        }

        //armado de las imagenes del producto
        $imagenes = $this->imagenProductoService->getAllImagenesAcMatrizByProducto($prd_id);
        //dd($imagenes);

        //controlamos si es producto en oferta, nuevo o antiguo
        $oferta = false;
        $nuevo = false;
        $precioUnidadFinal = $producto->precio;
        $fechaActual = date('Y-m-d');
        $fechaDesde = date("Y-m-d",strtotime($fechaActual."- $diasNuevos days"));
        if (isset($producto->precio_oferta) && isset($producto->fecha_inicio_oferta) && isset($producto->fecha_fin_oferta)){
            if ($fechaActual >= $producto->fecha_inicio_oferta && $fechaActual <= $producto->fecha_fin_oferta){
                $oferta = true;
                $precioUnidadFinal = $producto->precio_oferta;
            }
        }
        if($oferta != true){
            if ($producto->fecha_registro >= $fechaDesde){
                $nuevo = true;
            }
        }

        $valoraciones = $this->valoracionProductoService->getValoracionesProductoByLimitSortByFechaDesc($prd_id,10);
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

        $productosRelacionados = $this->productoService->getAllProductosRelacionadosByCategoriaSortAndLimit(10,$producto->cat_id);
        return view('producto.ver',
            compact(
                'user',
                'producto',
                'imagenes',
                'oferta',
                'nuevo',
                'precioUnidadFinal',
                'valoraciones',
                'productosRelacionados',
                'diasNuevos',
                'telefonoWhatsapp',
                'linkPaginaFacebook',
                'paginaFacebook'
            ));
    }

    public function _guardarValoracion(Request $request)
    {
        $user = Auth::user();
        $data = array();
        $data['prd_id'] = $request->prd_id;
        $data['usr_id'] = $user->id;
        $data['puntuacion'] = $request->puntaje;
        $data['valoracion'] = $request->comentario;
        $data['fecha'] = date('Y-m-d H:i:s');
        $data['estado'] = 'AC';
        try {
            $valoracion = $this->valoracionProductoService->save($data);
            if (!empty($valoracion)){
                $valoraciones = $this->valoracionProductoService->getValoracionesProductoByLimitSortByFechaDesc($request->prd_id,10);
                $html = view('producto._valoraciones',compact('valoraciones'))->render();
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

    public function buscar(Request $request)
    {
        $cat_id = 0;
        $search = '';
        $sort = 1;
        $diasParametrica = $this->parametricaService->getParametricaByTipoAndCodigo('DIAS-PRODUCTO-NUEVO');
        $diasNuevos = $diasParametrica->valor1;
        if ($request->has('cat_id')){
            $cat_id = $request->cat_id;
        }
        if ($request->has('search')){
            $search = $request->search;
        }
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $productos = $this->productoService->getAllProductosBySearchAndSortAndPaginate($sort,$cat_id,$search,12);
        return view('producto.buscar',compact('productos','sort','diasNuevos','cat_id','search'));
    }

    //End Vistas de productos para clientes

}
