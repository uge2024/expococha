<?php
namespace App\Http\Controllers;
use App\Models\Denuncia;
use App\Services\DenunciaService;
use App\Services\ProductorService;
use App\Services\ProductoService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Image;
use Notification;
use Toastr;

class DenunciaController extends Controller
{
    protected $denunciaService;
    protected $userService;
    protected $productorService;
    protected $productoService;
    public function __construct(
        DenunciaService $denunciaService,
        UserService $userService,
        ProductorService $productorService,
        ProductoService $productoService)
    {
        $this->productorService = $productorService;
        $this->denunciaService = $denunciaService;
        $this->userService = $userService;
        $this->productoService = $productoService;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $user = Auth::user();
        $usr_id = $user->id;
        if ($request->has('search')){
            $searchtype = $request->searchtype;
            $search = $request->search;
        }
        if ($request->has('sort')){
            $sort = $request->sort;
        }
        $lista = $this->denunciaService->getAllPaginateBySearchAndSortACAndEl(10,$searchtype,$search,$sort);
        return view('denuncia.index',compact('lista','usr_id','searchtype','search','sort'));
    }

    public function show($den_id)
    {

        $denuncia = $this->denunciaService->getById($den_id);
        $user = $this->userService->getUser($denuncia->usr_id);
        $correo_usuario = $user->email;
        $nombre_tienda = '0';
        $nombre_producto = '0';
        $nombre_producto_feria = '0';

        if(empty($denuncia->pro_id)){
            if(empty($denuncia->prd_id) ){
                if(empty($denuncia->fpr_id)){
                    //vacio pro_id
                    //vacio prd_id
                    //vacio fpr_id
                }else{
                    //vacio pro_id
                    //vacio prd_id
                    //tiene fpr_id  falta
                    $productoferia = $this->feriaProductoService->getById($denuncia->fpr_id);
                    $nombre_producto_feria = $productoferia->nombre_producto;
                }
            }else {//tine prd_id
                $producto = $this->productoService->getById($denuncia->prd_id);
                $productor = $this->productorService->getById($producto->pro_id);
                if(empty($denuncia->fpr_id)){
                    //vacio pro_id
                    //tiene prd_id
                    //vacio fpr_id
                    $nombre_tienda = $productor->nombre_tienda;
                    $nombre_producto = $producto->nombre_producto;
                }else{
                    //vacio pro_id
                    //tiene prd_id
                    //tiene fpr_id
                    $nombre_tienda = $productor->nombre_tienda;
                    $nombre_producto = $producto->nombre_producto;
                    $productoferia = $this->feriaProductoService->getById($denuncia->fpr_id);
                    $nombre_producto_feria = $productoferia->nombre_producto;
                }
            }
        }else{//tiene pro_id
            $productor = $this->productorService->getById($denuncia->pro_id);
            $nombre_tienda = $productor->nombre_tienda;
            if(empty($denuncia->prd_id) ){
                if(empty($denuncia->fpr_id)){
                    //vacio prd_id
                    //vacio fpr_id
                }else{
                    //vacio prd_id
                    //tiene fpr_id
                    $productoferia = $this->feriaProductoService->getById($denuncia->fpr_id);
                    $nombre_producto_feria = $productoferia->nombre_producto;
                }
            }else {
                $producto = $this->productoService->getById(1);
                $nombre_producto = $producto->nombre_producto;
                if(empty($denuncia->fpr_id)){
                    //vacio fpr_id
                }else{
                    //tiene fpr_id
                    $productoferia = $this->feriaProductoService->getById($denuncia->fpr_id);
                    $nombre_producto_feria = $productoferia->nombre_producto;
                }
            }
        }
        return view('denuncia.show',compact('denuncia','correo_usuario','nombre_tienda','nombre_producto','nombre_producto_feria'));
    }

    public function midenuncia(Request $request)
    {
        $user = Auth::user();
        if(empty($user)) {
            Toastr::warning('Debe de registrar en la pagina para poder realizar la denuncia!', "");
            return back()->withInput();
        }else{
            $correo_usuario = $user->email;
            $usr_id = $user->id;
            $denuncia = new Denuncia();
            $denuncia->den_id = 0;
            $denuncia->estado = 'AC';

            if($request->has('pro_id')){
                if($request->has('prd_id')){
                    if($request->has('fpr_id')){
                        $pro_id = $request->pro_id;
                        $prd_id = $request->prd_id;
                        $fpr_id = $request->fpr_id;
                    }else{
                        $pro_id = $request->pro_id;
                        $prd_id = $request->prd_id;
                        $fpr_id = null;
                    }
                }else{
                    if($request->has('fpr_id')){
                        $pro_id = $request->pro_id;
                        $prd_id = null;
                        $fpr_id = $request->fpr_id;
                    }else{
                        $pro_id = $request->pro_id;
                        $prd_id = null;
                        $fpr_id = null;
                    }
                }
            }else{
                if($request->has('prd_id')){
                    if($request->has('fpr_id')){
                        $pro_id = null;
                        $prd_id = $request->prd_id;
                        $fpr_id = $request->fpr_id;
                    }else{
                        $pro_id = null;
                        $prd_id = $request->prd_id;
                        $fpr_id = null;
                    }
                }else{
                    if($request->has('fpr_id')){
                        $pro_id = null;
                        $prd_id = null;
                        $fpr_id = $request->fpr_id;
                    }else{
                        $pro_id = null;
                        $prd_id = null;
                        $fpr_id = null;
                    }
                }
            }
            return view('denuncia.create',compact('denuncia','correo_usuario','usr_id','pro_id','prd_id','fpr_id'));
        }
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
            try {
                    $denuncia = $this->denunciaService->save($data);
                    if (empty($denuncia)) {
                        Toastr::warning('No se pudo guardar el denuncia', "");
                         return redirect()->back()->withInput();
                    }else{
                        Toastr::success('Operación completada ', "");
                        return redirect('/');
                    }

                } catch (Exception $e) {
                    Log::error($e->getMessage());
                    Toastr::error('Ocurrio un error al guardar la denuncia', "");
                    return back()->withInput();
            }

    }

}
