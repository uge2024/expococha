<?php
namespace App\Http\Controllers;

use App\Models\FeriaProductor;
use App\Models\Productor;
use App\Services\AuditoriaService;
use App\Services\CertificadoFeriaService;
use App\Services\CertificadoService;
use App\Services\CorreoEnviadoService;
use App\Services\FeriaProductorService;
use App\Services\FeriaVirtualService;
use App\Services\ImagenFeriaVirtualService;
use App\Services\InstitucionService;
use App\Services\ParametricaService;
use App\Services\ProductorService;
use App\Services\RubroService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;
use Notification;
use Toastr;
use PDF;

class FeriaProductorController extends Controller
{
    protected $feriaVirtualService;
    protected $rubroService;
    protected $parametricaService;
    protected $imagenFeriaVirtualService;
    protected $productorService;
    protected $correoEnviadoService;
    protected $userService;
    protected $feriaProductorService;
    protected $auditoriaService;
    protected $institucionService;
    protected $certificadoService;
    protected $certificadoFeriaService;
    public function __construct(
        FeriaVirtualService $feriaVirtualService,
        RubroService $rubroService,
        ParametricaService $parametricaService,
        ImagenFeriaVirtualService $imagenFeriaVirtualService,
        Productor $productor,
        ProductorService $productorService,
        CorreoEnviadoService $correoEnviadoService,
        UserService $userService,
        FeriaProductorService $feriaProductorService,
        AuditoriaService $auditoriaService,
        InstitucionService $institucionService,
        CertificadoService $certificadoService,
        CertificadoFeriaService $certificadoFeriaService
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
        $this->auditoriaService = $auditoriaService;
        $this->institucionService = $institucionService;
        $this->certificadoService = $certificadoService;
        $this->certificadoFeriaService = $certificadoFeriaService;
        $this->middleware('auth');
    }

    public function index($fev_id)
    {
        $feriavirtual = $this->feriaVirtualService->getById($fev_id);
        $lista = $this->feriaProductorService->getFeriaProductorByferia($fev_id,10);
        $titulo = $feriavirtual->nombre;
        return view('feriaproductor.index', compact('lista','fev_id','titulo'));
    }

    public function create($fev_id)
    {
        $feriaProductor = new FeriaProductor();
        $feriaVirtual = $this->feriaVirtualService->getById($fev_id);
        $titulo = $feriaVirtual->nombre;
        $feriaProductor->rub_id = 0;
        $feriaProductor->estado = 'AC';
        //falta mejorar el control controlar
        //$listaProductores = $this->productorService->getProductorComboByFeria($fev_id);

        $user = Auth::user();
        $usr_id = $user->id;
        $nombreUsuario = $user->name;

        $rubros = $this->rubroService->getComboRubros();
        $rub_id = 0;
        $listaProductores = new Collection();
        $listaProductores->prepend('Seleccione un productor','');
        return view('feriaproductor.createedit',compact('feriaProductor','fev_id','titulo','listaProductores','usr_id','nombreUsuario','rubros','rub_id'));
    }

    public function edit($fpd_id)
    {
        $feriaProductor = $this->feriaProductorService->getById($fpd_id);
        $fev_id = $feriaProductor->fev_id;
        $usr_id = $feriaProductor->usr_id;
        $feriaVirtual = $this->feriaVirtualService->getById($fev_id);
        //$listaProductores = $this->productorService->getProductorComboByFeria($fev_id);
        $titulo = $feriaVirtual->nombre;
        $user = $this->userService->getUser($usr_id);
        $nombreUsuario =$user->name;

        $rubros = $this->rubroService->getComboRubros();
        $rub_id = $feriaProductor->productor->rub_id;
        $listaProductores = $this->productorService->getProductorComboByRubro($rub_id);
        //$listaProductores->prepend('Seleccione un productor','');

        return view('feriaproductor.createedit',compact('feriaProductor','usr_id','fev_id','titulo','listaProductores','nombreUsuario','rubros','rub_id'));
    }

    public function _selectproductores(Request $request)
    {
        $listaProductores = $this->productorService->getProductorComboByRubro($request->rub_id);
        return view('feriaproductor._selectproductores',compact('listaProductores'));
    }

    public  function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->except('_token');
        if($request->fpd_id == 0 ) {
            $fev_id = $data['fev_id'];
            $pro_id = $data['pro_id'];
            if($pro_id > 0){

                $feriaProductor = $this->feriaProductorService->ExisteFeriaProductor($fev_id,$pro_id);
                if(count($feriaProductor)==0){
                    $messages = [
                        'required' => 'El campo :attribute es requerido.',
                        'fecha_inscripcion.required' => 'El campo fecha inscripcion es requerido',
                        'comprobante.required' => 'El campo comprobante es requerido',
                        'fecha_pago.required' => 'El campo  fecha pago es requerido',
                        'monto.required' => 'El campo monto es requerido'
                    ];
                    $validator = Validator::make($data, [
                        'fecha_inscripcion' => 'required',
                        'comprobante' => 'required',
                        'fecha_pago' => 'required',
                        'monto' => 'required'
                    ], $messages);

                    if ($validator->fails()) {
                        Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                        return back()->withErrors($validator)->withInput();
                    }
                    $fecha_a = $request->fecha_inscripcion;
                    $fecha_a = str_replace('/','-',$fecha_a);
                    $data['fecha_inscripcion'] = date('Y-m-d', strtotime($fecha_a));
                    $fecha_b = $request->fecha_pago;
                    $fecha_b = str_replace('/','-',$fecha_b);
                    $data['fecha_pago'] = date('Y-m-d', strtotime($fecha_b));

                    try {
                        $feriaProductor = $this->feriaProductorService->save($data);
                        //logs
                        $audi = ['ip'=>$request->ip(),'tabla'=>'fpd_feria_productor','usuario'=>$user->id.'-'.$user->name,
                            'fecha'=>date('Y-m-d H:i:s'),'accion'=>'registrar productor a feria',
                            'datos'=>json_encode($data)];
                        $this->auditoriaService->save($audi);

                        if (empty($feriaProductor)) {
                            Toastr::warning('No se pudo guardar la feria Productor',"");
                            return back()->withInput();
                        }else{
                            Toastr::success('Operación completada',"");
                            return redirect('feriaproductor/create/'.$data['fev_id']);
                        }
                    } catch (Exception $e) {
                        Log::error($e->getMessage());
                        Toastr::error('Ocurrio un error al guardar la feria Productor',"");
                        return back()->withInput();
                    }
                }else{
                       Toastr::warning('El productor ya fue asignado a feria, por favor seleccione otro Productor'," ");
                       return back()->withInput();
                }
            }else{
                Toastr::warning('Debe de seleccionar un  Productor'," ");
                return back()->withInput();
            }

        }else{
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'fecha_inscripcion.required' => 'El campo fecha inscripcion es requerido',
                'comprobante.required' => 'El campo comprobante es requerido',
                'fecha_pago.required' => 'El campo  fecha pago es requerido',
                'monto.required' => 'El campo monto es requerido'
            ];
            $validator = Validator::make($data, [
                'fecha_inscripcion' => 'required',
                'comprobante' => 'required',
                'fecha_pago' => 'required',
                'monto' => 'required'
            ], $messages);
            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            $fecha_a = $request->fecha_inscripcion;
            $fecha_a = str_replace('/','-',$fecha_a);
            $data['fecha_inscripcion'] = date('Y-m-d', strtotime($fecha_a));
            $fecha_b = $request->fecha_pago;
            $fecha_b = str_replace('/','-',$fecha_b);
            $data['fecha_pago'] = date('Y-m-d', strtotime($fecha_b));

            try {
                $feriaProductor = $this->feriaProductorService->update($data);
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'fpd_feria_productor','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'actualizar registro productor a feria',
                    'datos'=>json_encode($data)];
                $this->auditoriaService->save($audi);

                if (empty($feriaProductor)) {
                    Toastr::warning('No se pudo editar la feria productor',"");
                    return back()->withInput();
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('feriaproductor/'.$request->fev_id);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la feria productor',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        $user = Auth::user();
        $feriaProductor = $this->feriaProductorService->getById($request->fpd_id);
        if (!empty($feriaProductor)) {
            if($this->feriaProductorService->delete($feriaProductor,$request->texto)){
                //logs
                $audi = ['ip'=>$request->ip(),'tabla'=>'fpd_feria_productor','usuario'=>$user->id.'-'.$user->name,
                    'fecha'=>date('Y-m-d H:i:s'),'accion'=>'habilitar/inhabilitar productor a feria',
                    'datos'=>" fpd_id: $request->fpd_id, estado: $request->texto "];
                $this->auditoriaService->save($audi);

                return response()->json([
                    'res' => true
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se encontro la feria productor'
                ]);
            }
        }
        return response()->json([
            'res' => false,
            'mensaje' => 'No se encontro la feria productor'
        ]);
    }

    //certificado de participacion
    public function existecertificado(Request $request){
        $fpd_id = $request->fpd_id;
        $pro_id = $request->pro_id;
        $user = Auth::user();
        $feriaProductor = $this->feriaProductorService->getById($fpd_id);
        $feriaVirtual = $this->feriaVirtualService->getById($feriaProductor->fev_id);
        $certificado = $this->certificadoService->getByProductorAndFeria($pro_id,$feriaVirtual->fev_id);
        if (empty($certificado)){
            return response()->json([
                'res' => false,
                'mensaje' => 'No se encontro certificado'
            ]);
        }else{
            return response()->json([
                'res' => true,
                'fecha'=> date('d/m/Y H:i:s',strtotime($certificado->fecha)),
                'usuario'=> $certificado->usuario,
                'mensaje' => 'Se encontro certificado'
            ]);
        }
    }

    public function certificado(Request $request,$fpd_id,$pro_id)
    {
        //dd($fpd_id,$pro_id);
        $user = Auth::user();
        $institucion = $this->institucionService->getById(1);
        $feriaProductor = $this->feriaProductorService->getById($fpd_id);
        $productor = $this->productorService->getById($pro_id);
        $feriaVirtual = $this->feriaVirtualService->getById($feriaProductor->fev_id);

        //fondo certificado
        $fondo = asset('/images/certificadobase.png');
        $certificadoFeria = $this->certificadoFeriaService->getByFeria($feriaVirtual->fev_id);
        if (!empty($certificadoFeria)){
            $fondo = asset('storage/uploads/'.$certificadoFeria->fondo);
        }

        $certificado = $this->certificadoService->getByProductorAndFeria($pro_id,$feriaVirtual->fev_id);
        if (empty($certificado)){
            $data = array();
            $data['ip'] = $request->ip();
            $data['usuario'] = $user->name;
            $data['fecha'] = date('Y-m-d H:i:s');
            $data['codigo'] = Str::uuid();
            $data['nombre'] = $productor->nombre_propietario;
            $data['feria'] = $feriaVirtual->nombre;
            $data['version'] = $feriaVirtual->version;
            $data['fecha_inicio'] = $feriaVirtual->fecha_inicio;
            $data['fecha_final'] = $feriaVirtual->fecha_final;
            $data['estado'] = 'AC';
            $data['pro_id'] = $pro_id;
            $data['fev_id'] = $feriaVirtual->fev_id;
            $certificado = $this->certificadoService->save($data);
        }else{
            $data = array();
            $data['cer_id'] = $certificado->cer_id;
            $data['ip'] = $request->ip();
            $data['usuario'] = $user->name;
            $data['fecha'] = date('Y-m-d H:i:s');
            $certificado = $this->certificadoService->update($data);
        }

        $certificados = new Collection();
        $certificados->add($certificado);
        $pdf = PDF::loadView('feriaproductor.certificado',compact(
            'user',
            'institucion',
            'certificados',
            'fondo'
        ));
        $pdf->setPaper('letter', 'landscape');
        return $pdf->stream('certificado.pdf');
    }

    //certificado de participacion todos
    public function existencertificados(Request $request){
        $user = Auth::user();
        $fev_id = $request->fev_id;
        $certificados = $this->certificadoService->getAllByFeria($fev_id);
        if ($certificados->count() == 0){
            return response()->json([
                'res' => false,
                'mensaje' => 'No se encontro certificados'
            ]);
        }else{
            return response()->json([
                'res' => true,
                'mensaje' => 'Se encontro certificados ya impresos'
            ]);
        }
    }

    public function certificados(Request $request,$fev_id)
    {
        $user = Auth::user();
        $institucion = $this->institucionService->getById(1);
        $feriaVirtual = $this->feriaVirtualService->getById($fev_id);
        $productores = $this->productorService->getAllProductoresByFeriaVirtual($fev_id);

        //fondo certificado
        $fondo = asset('/images/certificadobase.png');
        $certificadoFeria = $this->certificadoFeriaService->getByFeria($feriaVirtual->fev_id);
        if (!empty($certificadoFeria)){
            $fondo = asset('storage/uploads/'.$certificadoFeria->fondo);
        }

        $certificados = new Collection();
        foreach ($productores as $key=>$productor){
            $certificado = $this->certificadoService->getByProductorAndFeria($productor->pro_id,$feriaVirtual->fev_id);
            if (empty($certificado)){
                $data = array();
                $data['ip'] = $request->ip();
                $data['usuario'] = $user->name;
                $data['fecha'] = date('Y-m-d H:i:s');
                $data['codigo'] = Str::uuid();
                $data['nombre'] = $productor->nombre_propietario;
                $data['feria'] = $feriaVirtual->nombre;
                $data['version'] = $feriaVirtual->version;
                $data['fecha_inicio'] = $feriaVirtual->fecha_inicio;
                $data['fecha_final'] = $feriaVirtual->fecha_final;
                $data['estado'] = 'AC';
                $data['pro_id'] = $productor->pro_id;
                $data['fev_id'] = $feriaVirtual->fev_id;
                $certificado = $this->certificadoService->save($data);
            }else{
                $data = array();
                $data['cer_id'] = $certificado->cer_id;
                $data['ip'] = $request->ip();
                $data['usuario'] = $user->name;
                $data['fecha'] = date('Y-m-d H:i:s');
                $certificado = $this->certificadoService->update($data);
            }
            $certificados->add($certificado);
        }

        $pdf = PDF::loadView('feriaproductor.certificado',compact(
            'user',
            'institucion',
            'certificados',
            'fondo'
        ));
        $pdf->setPaper('letter', 'landscape');
        return $pdf->stream('certificados.pdf');
    }

}
