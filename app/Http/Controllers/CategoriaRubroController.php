<?php
namespace App\Http\Controllers;


use App\Models\CategoriaRubro;
use App\Models\Rubro;
use App\Services\CategoriaRubroService;
use App\Services\RubroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Toastr;

class CategoriaRubroController extends Controller
{
    protected $categoriaRubroService;
    private $rubroService;

    public function __construct(CategoriaRubroService $categoriaRubroService,RubroService $rubroService)
    {
        $this->categoriaRubroService = $categoriaRubroService;
        $this->rubroService = $rubroService;
        $this->middleware('auth');
    }
    
    public function listacategoria($rub_id)
    {
        $rubro = $this->rubroService->getById($rub_id);
        $titulo = $rubro->nombre;
        $lista = $this->categoriaRubroService->getAllPaginateCategoriasByRubro(10,$rub_id);
        return view('rubro.listacategoria',compact('lista','titulo','rub_id'));
    }

    public function create($rub_id)
    {
        $categoriaRubro = new CategoriaRubro();
        $categoriaRubro->cat_id = 0;
        $categoriaRubro->estado = 'AC';
        $rubro = $this->rubroService->getById($rub_id);
        $nombrerubro = $rubro->nombre;
        $listaCategoriaRubrosPadre = $this->categoriaRubroService->cargarComboCategoriasByRubro($rub_id);
        return view('rubro.createeditcategoria',compact('categoriaRubro','nombrerubro','listaCategoriaRubrosPadre','rub_id'));
    }

    public function edit($cat_id,$rub_id)
    {
        $categoriaRubro = $this->categoriaRubroService->getById($cat_id);
        $rubro = $this->rubroService->getById($rub_id);
        $nombrerubro = $rubro->nombre;
        $listaCategoriaRubrosPadre = $this->categoriaRubroService->cargarComboCategoriasByRubro($rub_id);
        return view('rubro.createeditcategoria',compact('categoriaRubro','nombrerubro','listaCategoriaRubrosPadre','rub_id'));
    }
    public  function store(Request $request)
    {
        $data = $request->except('_token');
        if($request->cat_id == 0 ) {

                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                    'nombre.required' => 'El campo nombre es requerido',
                    'descripcion.required' => 'El campo descripcion es requerido',
                ];
                $validator = Validator::make($data, [
                    'nombre' => 'required',
                    'descripcion' => 'required'
                ], $messages);

                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }
                if($data['padre_id'] =='0'){
                    $data['nivel'] = 1;
                }else{
                    $nivelpadre = $this->obtenerValorPabre($data['padre_id']);
                    $data['nivel'] = $nivelpadre + 1;
                }
                try {
                    $categoriaRubro = $this->categoriaRubroService->saveCategoriaRuData($data);
                    if (empty($categoriaRubro)) {
                        Toastr::warning('No se pudo guardar la categoria rubro',"");
                    }
                    Toastr::success('Operación completada',"");
                    return redirect('rubro/categoriarubro/listacategoria/'.$categoriaRubro->rub_id);
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                    Toastr::error('Ocurrio un error al guardar la Categoria rubro',"");
                    return back()->withInput();
                }
        }else{
                $messages = [
                    'required' => 'El campo :attribute es requerido.',
                    'nombre.required' => 'El campo nombre es requerido',
                    'descripcion.required' => 'El campo descripcion es requerido',
                ];

                $validator = Validator::make($data, [
                    'nombre' => 'required',
                    'descripcion' => 'required'
                ], $messages);
                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }
                if($data['padre_id'] =='0'){
                    $data['nivel'] = 1;
                }else{
                    $nivelpadre = $this->obtenerValorPabre($data['padre_id']);
                    $data['nivel'] = $nivelpadre + 1;
                }
                try {
                    $categoriaRubro = $this->categoriaRubroService->update($data);
                    if (empty($categoriaRubro)) {
                        Toastr::warning('No se pudo editar la categoria rubro',"");
                    }
                    Toastr::success('Operación completada',"");
                    return redirect('rubro/categoriarubro/listacategoria/'.$categoriaRubro->rub_id);
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                    Toastr::error('Ocurrio un error al editar la categoria rubro',"");
                    return back()->withInput();
                }
        }
    }

    public function _modificarEstado(Request $request)
    {
        $categoriaRubro = $this->categoriaRubroService->getById($request->cat_id);
        if (!empty($categoriaRubro)) {
            $this->categoriaRubroService->delete($categoriaRubro,$request->texto);
            return response()->json([
                'res' => true
            ]);
        }
        return response()->json([
            'res' => false,
            'mensaje' => 'No se encontro la categoria Rubro'
        ]);
    }

    public function obtenerValorPabre($padre_id){
        $categoriaRubro = $this->categoriaRubroService->getById($padre_id);
        return $categoriaRubro->nivel;
    }

    public function _cargarComboCategoriasByRubro(Request $request){
        $listaCategoriaRubrosPadre = $this->categoriaRubroService->cargarComboCategoriasByRubro($request->rub_id);
      return view('rubro._combocategoriabyrubro',compact('listaCategoriaRubrosPadre'));
    }


}
