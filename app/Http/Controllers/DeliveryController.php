<?php
namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Services\DeliveryService;
use App\Services\ProductorService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Notification;
use Toastr;

class DeliveryController extends Controller
{
    private $productorService;
    private $deliveryService;
    public function __construct(DeliveryService $deliveryService,ProductorService $productorService)
    {
        $this->deliveryService = $deliveryService;
        $this->productorService = $productorService;
        $this->middleware('auth');
    }

    public function index($usr_id)
    {
        $productorexistente = $this->productorService->getProductorByUser($usr_id);
        if(empty($productorexistente)) {
            Toastr::warning('Por fabor registre sus datos de Productor!', "");
            return back()->withInput();
        }else{
            $pro_id = $productorexistente->pro_id;
            $productor = $this->productorService->getById($pro_id);
            $titulo = "";   
            if ($productor) {
                $titulo = $productor->nombre_tienda;
            }
            $lista = $this->deliveryService->getAllPaginateDeliveryByProductor(10, $pro_id);
            return view('delivery.index', compact('lista', 'titulo', 'pro_id','usr_id'));
        }
    }

    public function create($pro_id,$usr_id)
    {
        $delivery = new Delivery();
        $delivery->del_id = 0;
        $delivery->estado = 'AC';
        return view('delivery.createedit',compact('delivery','pro_id','usr_id'));
    }

    public function edit($del_id)
    {
        $delivery = $this->deliveryService->getById($del_id);
        $pro_id = $delivery->pro_id;
        $productor =  $this->productorService->getById($pro_id);
        $usr_id = $productor->usr_id;
        $user = User::where('id','=',$usr_id)->first();
        $usr_id= $user->id;
        return view('delivery.createedit',compact('delivery','pro_id','usr_id'));
    }

    public  function store(Request $request)
    {
        $data = $request->except('_token');
        if($request->del_id == 0 ) {

            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'razon_social.required' => 'El campo razon social es requerido',
                'disponible.required' => 'El campo disponible es requerido',
                'tipo_transporte.required' => 'El campo tipo transporte es requerido',
            ];
            $validator = Validator::make($data, [
                'razon_social' => 'required',
                'disponible' => 'required',
                'tipo_transporte' => 'required'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            try {
                $delivery = $this->deliveryService->save($data);
                if (empty($delivery)) {
                    Toastr::warning('No se pudo guardar el delivery',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('delivery/'.$data['usr_id']);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la Categoria rubro',"");
                return back()->withInput();
            }
        }else{
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'razon_social.required' => 'El campo razon social es requerido',
                'disponible.required' => 'El campo disponible es requerido',
                'tipo_transporte.required' => 'El campo tipo transporte es requerido',
            ];
            $validator = Validator::make($data, [
                'razon_social' => 'required',
                'disponible' => 'required',
                'tipo_transporte' => 'required'
            ], $messages);
            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            try {
                $delivery = $this->deliveryService->update($data);
                if (empty($delivery)) {
                    Toastr::warning('No se pudo editar el delivery',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('delivery/'.$data['usr_id']);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la categoria rubro',"");
                return back()->withInput();
            }
        }
    }

    public function _modificarEstado(Request $request)
    {
        $delivery = $this->deliveryService->getById($request->del_id);
        if (!empty($delivery)) {
            if($this->deliveryService->delete($delivery,$request->texto)){
                return response()->json([
                    'res' => true
                ]);
            }else{
                return response()->json([
                    'res' => false,
                    'mensaje' => 'No se encontro el Delivery'
                ]);
            }
        }
        return response()->json([
            'res' => false,
            'mensaje' => 'No se encontro el Delivery'
        ]);
    }


}
