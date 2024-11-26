<?php


namespace App\Http\Controllers;
use App\Models\Asociacion;
use App\Services\AsociacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Notification;
use Toastr;

class AsociacionController extends Controller
{
    protected $asociacionService;
    public function __construct(AsociacionService $asociacionService)
    {
        $this->asociacionService = $asociacionService;
        $this->middleware('auth');
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
        $lista = $this->asociacionService->getAllPaginateBySearchAndSort(10,$searchtype,$search,$sort);
        return view('asociacion.index',compact('lista','searchtype','search','sort'));
    }

    public function create()
    {
        $asociacion = new Asociacion();
        $asociacion->aso_id = 0;
        $asociacion->estado = 'AC';
        $aso_id = 0;
        return view('asociacion.createedit',compact('asociacion','aso_id'));
    }

    public function edit($aso_id)
    {
        $asociacion = $this->asociacionService->getById($aso_id);
        return view('asociacion.createedit',compact('asociacion','aso_id'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        if($request->aso_id == 0 ) {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'sigla.required' => 'El campo sigla es requerido',
                'nombre.required' => 'El campo nombre es requerido',
                'actividad.required' => 'El campo actividad es requerido',
                'direccion.required' => 'El campo direccion es requerida '
            ];

            $validator = Validator::make($data, [
                'sigla' => 'required',
                'nombre' => 'required',
                'actividad' => 'required',
                'direccion' => 'required'
            ], $messages);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            try {
                $asociacion = $this->asociacionService->save($data);
                if (empty($asociacion)) {
                    Toastr::warning('No se pudo guardar la asociacion', "");
                }else{
                    Toastr::success('Operación completada ', "");
                    return redirect('asociacion');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la asociacion', "");
                return back()->withInput();
            }
        }else{
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'sigla.required' => 'El campo sigla es requerido',
                'nombre.required' => 'El campo nombre es requerido',
                'actividad.required' => 'El campo actividad es requerido',
                'direccion.required' => 'El campo direccion es requerida '
            ];

            $validator = Validator::make($data, [
                'sigla' => 'required',
                'nombre' => 'required',
                'actividad' => 'required',
                'direccion' => 'required'
            ], $messages);

            if ($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            try {
                $asociacion = $this->asociacionService->update($data);
                if(empty($asociacion)){
                    Toastr::warning('No se pudo editar la asociacion', "");
                }else{
                    Toastr::success('Operación completada ', "");
                    return redirect('asociacion');
                }
            }catch (Exception $e){
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la asociacion', "");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        $asociacion = $this->asociacionService->getById($request->aso_id);
        if (!empty($asociacion)) {
            if($this->asociacionService->delete($asociacion)){
                return response()->json([
                    'res' => true
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se encontro la asociacion'
                ]);
            }
        }
        return response()->json([
            'res' => false,
            'mensaje' => 'No se encontro la asociacion'
        ]);
    }






}
