<?php

namespace App\Http\Controllers;
use App\Models\Rubro;
use App\Services\RubroService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Image;
use Notification;
use Toastr;

class RubroController extends Controller
{
    protected $rubroService;
    public function __construct(RubroService $rubroService)
    {
        $this->rubroService = $rubroService;
        $this->middleware('auth');
    }

    public function index()
    {
        $lista = $this->rubroService->getAllPaginate(10);
        return view('rubro.index',compact('lista'));
    }

    public function create()
    {
        $rubro = new Rubro();
        $rubro->rub_id = 0;
        $rubro->estado = 'AC';
        return view('rubro.createedit',compact('rubro'));
    }

    public function edit($rub_id)
    {
        $rubro = $this->rubroService->getById($rub_id);
        return view('rubro.createedit',compact('rubro'));
    }


    public function store(Request $request)
    {
        $data = $request->except('_token');
        $ruta = storage_path('app/public/uploads/');
        if($request->rub_id == 0 ) {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'imagen_banner_imagen.required' => 'La imagen banner es requerida ',
                'imagen_icono_imagen.required' => 'La imagen icono es requerida',
                'imagen_icono_imagen.*.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes',
                'imagen_banner_imagen.*.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes',
            ];

            $validator = Validator::make($data, [
                'nombre' => 'required',
                'descripcion' => 'required',
                'imagen_banner_imagen' => 'required',
                'imagen_icono_imagen' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000',
                'imagen_banner_imagen.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000'
            ], $messages);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

           if ($request->hasFile('imagen_banner_imagen')) {
                $file = $request->imagen_banner_imagen;
                $extencionImagen =$file->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                $data['imagen_banner'] = $nombreUno;
                $imagenUno =Image::make($file);
                $imagenUno->resize(1920,480);
                $imagenUno->save($ruta.$nombreUno,95);
            }

            if ($request->hasFile('imagen_icono_imagen')) {
                $file2 = $request->imagen_icono_imagen;
                $extencionImagen2 =$file2->extension();
                $nombreIcono = time().''.uniqid().'.'.$extencionImagen2;
                $data['imagen_icono'] = $nombreIcono;
                $imagenIcono =Image::make($file2);
                $imagenIcono->resize(255,165);
                $imagenIcono->save($ruta.$nombreIcono,95);
            }

            try {
                    $rubro = $this->rubroService->saveRubroData($data);
                    if (empty($rubro)) {
                        Toastr::warning('No se pudo guardar el rubro', "");
                        return back()->withInput();
                    }else{
                        Toastr::success('Operación completada ', "");
                        return redirect('rubro');
                    }
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    Toastr::error('Ocurrio un error al guardar la Rubro', "");
                    return back()->withInput();
            }
        }else{
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'nombre.required' => 'El campo nombre es requerido',
                'descripcion.required' => 'El campo descripcion es requerido',
                'imagen_banner_imagen.required' => 'La imagen banner es requerida ',
                'imagen_icono_imagen.required' => 'La imagen icono es requerida',
                'imagen_icono_imagen.*.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes',
                'imagen_banner_imagen.*.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes',
            ];

            $validator = Validator::make($data, [
                'nombre' => 'required',
                'descripcion' => 'required',
                'imagen_icono_imagen' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000',
                'imagen_banner_imagen.*' => 'mimes:jpeg,jpg,JPEG,JPG|max:2000'
            ],$messages);

            if ($validator->fails()){
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            if ($request->hasFile('imagen_banner_imagen')) {
                $messages = [ 'imagen_banner_imagen.max' => 'El peso de la imagen banner no debe ser mayor a 2000 kilobytes'  ];
                $validator = Validator::make($data, ['imagen_banner_imagen' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique el formato o tamaño de la imagen banner', "");
                    return back()->withErrors($validator)->withInput();
                }
                $file = $request->imagen_banner_imagen;
                $extencionImagen =$file->extension();
                $nombreUno = time().''.uniqid().'.'.$extencionImagen;
                $data['imagen_banner'] = $nombreUno;
                $imagenUno =Image::make($file);
                $imagenUno->resize(1920,480);
                $imagenUno->save($ruta.$nombreUno,95);
            }
            if ($request->hasFile('imagen_icono_imagen')) {
                 $messages = [ 'imagen_icono_imagen.max' => 'El peso de la imagen icono no debe ser mayor a 2000 kilobytes'  ];
                $validator = Validator::make($data, ['imagen_icono_imagen' => 'mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2000' ], $messages);
                if ($validator->fails()){
                    Toastr::warning('No se pudo guardar ningun cambio verifique el formato o tamaño de la imagen', "");
                    return back()->withErrors($validator)->withInput();
                }
                $file2 = $request->imagen_icono_imagen;
                $extencionImagen2 =$file2->extension();
                $nombreIcono = time().''.uniqid().'.'.$extencionImagen2;
                $data['imagen_icono'] = $nombreIcono;
                $imagenIcono =Image::make($file2);
                $imagenIcono->resize(255,165);
                $imagenIcono->save($ruta.$nombreIcono,95);
            }

                try {
                    $rubro = $this->rubroService->update($data);
                    if (empty($rubro)){
                        Toastr::warning('No se pudo editar el rubro', "");
                        return back()->withInput();
                    }else{
                        Toastr::success('Operación completada ', "");
                        return redirect('rubro');
                    }

                }catch (\Exception $e){
                    Log::error($e->getMessage());
                    Toastr::error('Ocurrio un error al editar el Rubro', "");
                    return back()->withInput();
                }
        }
    }

    public function _modificarEstado(Request $request)
    {
            $rubro = $this->rubroService->getById($request->rub_id);
            if (!empty($rubro)) {
                if($this->rubroService->delete($rubro,$request->texto)){
                return response()->json([
                    'res' => true
                ]);
                }else{
                    return response()->json([
                        'res' => false,
                        'mensaje' => 'No se encontro la rubro'
                    ]);
                }
            }
            return response()->json([
                'res' => false,
                'mensaje' => 'No se encontro la rubro'
            ]);
    }




}
