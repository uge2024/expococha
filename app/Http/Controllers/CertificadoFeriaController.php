<?php

namespace App\Http\Controllers;

use App\Models\CertificadoFeria;
use App\Services\CertificadoFeriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Toastr;
use Image;

class CertificadoFeriaController extends Controller
{
    protected $certificadoFeriaService;
    public function __construct(CertificadoFeriaService $certificadoFeriaService)
    {
        $this->certificadoFeriaService = $certificadoFeriaService;
        $this->middleware('auth');
    }

    public function createedit(Request $request,$fev_id)
    {
        $user = Auth::user();
        $ip = $request->ip();
        $certificado = $this->certificadoFeriaService->getByFeria($fev_id);
        if (empty($certificado)){
            $certificado = new CertificadoFeria();
            $certificado->cef_id = 0;
            $certificado->estado = 'AC';
            $certificado->ip = $ip;
            $certificado->usuario = $user->name;
            $certificado->fev_id = $fev_id;
        }
        return view('certificadoferia.create',compact('certificado'));
    }

    public function store(Request $request){
        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        $messages = [
            'required' => 'El campo :attribute es requerido.',
        ];

        $validator = Validator::make($data, [
            'ip' => 'required',
            'usuario' => 'required',
            'estado' => 'required',
            'fondo' => 'required|mimes:PNG,png|max:8000',
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data['fecha']= date('Y-m-d H:i:s');


        if ($request->hasFile('fondo')) {
            $file = $request->fondo;
            $extencionImagen =$file->extension();
            $nombreUno = time().''.uniqid().'.'.$extencionImagen;
            $data['fondo'] = $nombreUno;
            $imagenUno =Image::make($file);
            $imagenUno->resize(3059,2315);
            $imagenUno->save($ruta.$nombreUno,100);
        }

        try {
            $certificado = null;
            if ($request->cef_id == 0){
                $certificado = $this->certificadoFeriaService->save($data);
            }else{
                $certificado = $this->certificadoFeriaService->update($data);
            }

            if (empty($certificado)) {
                Toastr::error('No se pudo guardar la configuración del certificado', "");
                return back()->withInput();
            }else{
                Toastr::success('Operación completada ', "");
                return redirect('feriavirtual');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Toastr::error('Ocurrio un error al guardar la configuración del certificado', "");
            return back()->withInput();
        }

    }
}
