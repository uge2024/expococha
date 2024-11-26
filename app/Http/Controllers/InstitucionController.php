<?php
namespace App\Http\Controllers;

use App\Models\Institucion;
use App\Services\InstitucionService;
use App\Services\ParametricaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class InstitucionController extends Controller
{
    private $institucionService;
    private $parametricaService;
    public function __construct(InstitucionService $institucionService,ParametricaService $parametricaService)
    {
        $this->institucionService = $institucionService;
        $this->parametricaService = $parametricaService;
        $this->middleware('auth');
    }

    public function createedit()
    {
        $institucion = $this->institucionService->getAll();
        if(!$institucion){
            $ins_id = 0;
            $institucion = new Institucion();
            $institucion->ins_id = $ins_id;
            $institucion->estado = 'AC';
            return view('institucion.createedit',compact('institucion','ins_id'));
        }else{
            $ins_id = 1;
            $institucion = $this->institucionService->getById($ins_id);
            return view('institucion.createedit', compact('institucion', 'ins_id'));
        }
    }

    public function store(Request $request)
    {
        $tamImagenicoima = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-19");
        $tamImagenrepo = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN-21");
        $tamImagenbanner = $this->parametricaService->getParametricaByTipoAndCodigo("TIPO-IMAGEN_1");
        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        if($request->ins_id == 0) {
            $data['ins_id'] = 1;
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'sigla.required' => 'El campo sigla es requerido',
                'nombre.required' => 'El campo nombre es requerido',
                'descripcion .required' => 'El campo descripcion es requerida ',
                'direccion.required' => 'El campo direccion es requerida',
                'celular.required' => 'El campo celular es requerida',
                'celular_wp.required' => 'El campo celular_Whats App es requerida',
                'imagen_icono_imagen.required' => 'El campo imagen ocono es requerida'
            ];
            $validator = Validator::make($data, [
                'sigla' => 'required',
                'nombre' => 'required',
                'descripcion' => 'required',
                'direccion' => 'required',
                'celular' => 'required|size:8',
                'celular_wp' => 'required|size:8',
                'imagen_icono_imagen' => 'mimes:jpeg,jpg,JPEG,JPG,PNG,png|max:2000',
                'imagen_reporte_imagen' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000',
                'imagen_banner_imagen' => 'mimes:jpeg,jpg,JPEG,JPG|max:4000'
            ], $messages);

            if ($validator->fails()) {
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }
            if ($request->hasFile('imagen_icono_imagen')) {
                $file = $request->imagen_icono_imagen;
                $extencionImagen =$file->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                $data['imagen_icono_imagen'] = $nombreUno;
                $imagenUno =Image::make($file);
                $imagenUno->resize($tamImagenicoima->valor2,$tamImagenicoima->valor3);
                $imagenUno->save($ruta.$nombreUno,100);
            }
            if ($request->hasFile('imagen_reporte_imagen')) {
                $file2 = $request->imagen_reporte_imagen;
                $extencionImagen2 =$file2->extension();
                $nombreimagenreporte = time().''.uniqid().'.'.$extencionImagen2;
                $data['imagen_reporte_imagen'] = $nombreimagenreporte;
                $imagenIcono =Image::make($file2);
                $imagenIcono->resize($tamImagenrepo->valor2,$tamImagenrepo->valor3);//224x54
                $imagenIcono->save($ruta.$nombreimagenreporte,100);
            }
            if ($request->hasFile('imagen_banner_imagen')) {
                $file2 = $request->imagen_banner_imagen;
                $extencionImagen2 =$file2->extension();
                $nombrebanner = time().''.uniqid().'.'.$extencionImagen2;
                $data['imagen_banner_imagen'] = $nombrebanner;
                $imagenIcono =Image::make($file2);
                $imagenIcono->resize($tamImagenbanner->valor2,$tamImagenbanner->valor3);//1920x480
                $imagenIcono->save($ruta.$nombrebanner,100);
            }

            try {
                $institucion = $this->institucionService->save($data);
                if(empty($institucion)) {
                    Toastr::warning('No se pudo guardar la Institucion', "");
                }
                Toastr::success('Operación completada ', "");
                return redirect('institucion/createedit');
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al guardar la institucion', "");
                return back()->withInput();
            }
        }else{
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'sigla.required' => 'El campo sigla es requerido',
                'nombre.required' => 'El campo nombre es requerido',
                'descripcion .required' => 'El campo descripcion es requerida ',
                'direccion.required' => 'El campo direccion es requerida',
                'celular.required' => 'El campo celular es requerida',
                'celular_wp.required' => 'El campo celular Whats App es requerida',
                'imagen_icono_imagen.required' => 'El campo imagen ocono es requerida'
            ];
            $validator = Validator::make($data, [
                'sigla' => 'required',
                'nombre' => 'required',
                'descripcion' => 'required',
                'direccion' => 'required',
                'celular' => 'required|size:8',
                'celular_wp' => 'required|size:8',
                'imagen_icono_imagen' => 'mimes:jpeg,jpg,JPEG,JPG,PNG,png|max:2000',
                'imagen_reporte_imagen' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000',
                'imagen_banner_imagen' => 'mimes:jpeg,jpg,JPEG,JPG|max:4000'
            ],$messages);

            if($validator->fails()){
                Toastr::warning('No se pudo guardar ningun valor verifique los datos ingresados', "");
                return back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('imagen_icono_imagen')) {
                $file = $request->imagen_icono_imagen;
                $extencionImagen =$file->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                $data['imagen_icono_imagen'] = $nombreUno;
                $imagenUno =Image::make($file);
                $imagenUno->resize($tamImagenicoima->valor2,$tamImagenicoima->valor3);
                $imagenUno->save($ruta.$nombreUno,100);
            }

            if ($request->hasFile('imagen_reporte_imagen')) {
                $file2 = $request->imagen_reporte_imagen;
                $extencionImagen2 =$file2->extension();
                $nombreimagenreporte = time().''.uniqid().'.'.$extencionImagen2;
                $data['imagen_reporte_imagen'] = $nombreimagenreporte;
                $imagenIcono =Image::make($file2);
                $imagenIcono->resize($tamImagenrepo->valor2,$tamImagenrepo->valor3);//224x54
                $imagenIcono->save($ruta.$nombreimagenreporte,100);
            }

            if ($request->hasFile('imagen_banner_imagen')) {
                $file3 = $request->imagen_banner_imagen;
                $extencionImagen2 =$file3->extension();
                $nombrebanner = time().''.uniqid().'.'.$extencionImagen2;
                $data['imagen_banner_imagen'] = $nombrebanner;
                $imagenIcono =Image::make($file3);
                $imagenIcono->resize($tamImagenbanner->valor2,$tamImagenbanner->valor3);//1920x480
                $imagenIcono->save($ruta.$nombrebanner,100);
            }

            try {
                $institucion = $this->institucionService->update($data);
                if(empty($institucion)){
                    Toastr::warning('No se pudo editar la institucion', "");
                }
                Toastr::success('Operación completada ', "");
                return redirect('institucion/createedit');
            }catch (Exception $e){
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la institucion', "");
                return back()->withInput();
            }
        }
    }



}
