<?php


namespace App\Repositories;

use App\Models\ImagenProductor;

class ImagenProductorRepository
{

    protected $imagenProductor;
    public function __construct(ImagenProductor $imagenProductor)
    {
        $this->imagenProductor = $imagenProductor;
    }

    public function save($productor,$data):?ImagenProductor
    {
    	$pro_id = $productor['pro_id'];
        $arreglo = $data['imagen_banner'];
        $cantidadimagenesbannerhay = substr_count($arreglo,',');
        $i = 0;
        for($a=0; $a<=$cantidadimagenesbannerhay;$a++) {
            $iamgenN = explode(',', $arreglo);
                    $imagenProductor = new $this->imagenProductor;
                    $imagenProductor->imagen = $iamgenN[$a];
                    $imagenProductor->alto = $data['alto_banner'];
                    $imagenProductor->ancho = $data['ancho_banner'];
                    $imagenProductor->tipo = $data['tipo_banner'];
                    $imagenProductor->estado = 'AC';
                    $imagenProductor->pro_id = $pro_id;
                    $imagenProductor->save();
                    $imagenProductor->fresh();
                $i++;
        }

        $imagenProductor2 = new $this->imagenProductor;
        $imagenProductor2->imagen = $data['imagen_icono'];
        $imagenProductor2->alto = $data['alto_icono'];
        $imagenProductor2->ancho = $data['ancho_icono'];
        $imagenProductor2->tipo = $data['tipo_icono'];
        $imagenProductor2->estado = 'AC';
        $imagenProductor2->pro_id = $pro_id;
        $imagenProductor2->save();
        $imagenProductor2->fresh();

        $imagenProductor3 = new $this->imagenProductor;
        $imagenProductor3->imagen = $data['imagen_icono_dos'];
        $imagenProductor3->alto = $data['alto_icono_dos'];
        $imagenProductor3->ancho = $data['ancho_icono_dos'];
        $imagenProductor3->tipo = $data['tipo_icono_dos'];
        $imagenProductor3->estado = 'AC';
        $imagenProductor3->pro_id = $pro_id;
        $imagenProductor3->save();

        return $imagenProductor3->fresh();
    }

    public function getById($ipd_id,$tipo):?ImagenProductor
    {
        $imagenProductor = ImagenProductor::where('ipd_id','=',$ipd_id)->where('tipo','=',$tipo)->first();
        return $imagenProductor;
    }

    public function update($productor,$data)
    {
        $pro_id = $productor['pro_id'];
        if(isset($data['imagen_banner'])) {
            $arreglo = $data['imagen_banner'];
            $cantidadimagenesbannerhay = substr_count($arreglo,',');
            $i = 0;
            for($a=0; $a<=$cantidadimagenesbannerhay;$a++) {
                $iamgenN = explode(',', $arreglo);
                        $imagenProductor = new $this->imagenProductor;
                        $imagenProductor->imagen = $iamgenN[$a];
                        $imagenProductor->alto = $data['alto_banner'];
                        $imagenProductor->ancho = $data['ancho_banner'];
                        $imagenProductor->tipo = $data['tipo_banner'];
                        $imagenProductor->estado = 'AC';
                        $imagenProductor->pro_id = $pro_id;
                        $imagenProductor->save();
                        $imagenProductor->fresh();
                    $i++;
            }
        }

        if(isset($data['imagen_icono'])) {
            if($data['ipd_id_medio']!=0 && $data['ipd_id_icono']!=0){
                $imagenProductor2 = ImagenProductor::find($data['ipd_id_medio']);
                $imagenProductor2->imagen = $data['imagen_icono'];
                $imagenProductor2->alto = $data['alto_icono'];
                $imagenProductor2->ancho = $data['ancho_icono'];
                $imagenProductor2->tipo = $data['tipo_icono'];
                $imagenProductor2->estado = 'AC';
                $imagenProductor2->pro_id = $pro_id;
                $imagenProductor2->save();
                $imagenProductor2->fresh();

                $imagenProductor3 = ImagenProductor::find($data['ipd_id_icono']);
                $imagenProductor3->imagen = $data['imagen_icono_dos'];
                $imagenProductor3->alto = $data['alto_icono_dos'];
                $imagenProductor3->ancho = $data['ancho_icono_dos'];
                $imagenProductor3->tipo = $data['tipo_icono_dos'];
                $imagenProductor3->estado = 'AC';
                $imagenProductor3->pro_id = $pro_id;
                $imagenProductor3->save();
                $imagenProductor3->fresh();
            }else{
                $imagenProductor2 = new $this->imagenProductor;
                $imagenProductor2->imagen = $data['imagen_icono'];
                $imagenProductor2->alto = $data['alto_icono'];
                $imagenProductor2->ancho = $data['ancho_icono'];
                $imagenProductor2->tipo = $data['tipo_icono'];
                $imagenProductor2->estado = 'AC';
                $imagenProductor2->pro_id = $pro_id;
                $imagenProductor2->save();
                $imagenProductor2->fresh();

                $imagenProductor3 = new $this->imagenProductor;
                $imagenProductor3->imagen = $data['imagen_icono_dos'];
                $imagenProductor3->alto = $data['alto_icono_dos'];
                $imagenProductor3->ancho = $data['ancho_icono_dos'];
                $imagenProductor3->tipo = $data['tipo_icono_dos'];
                $imagenProductor3->estado = 'AC';
                $imagenProductor3->pro_id = $pro_id;
                $imagenProductor3->save();

            }


        }
        return $data;
    }

    public function getListaImagenProductorByProductor($pro_id,$tipo)
    {
        $imagenesProductor = ImagenProductor::where([
            ['pro_id','=',$pro_id],
            ['tipo','=',$tipo],
            ['estado','=','AC']
        ])->orderBy('pro_id','asc')->get();

        return $imagenesProductor;
    }


    public function getByIdImagenIcono($ipd_id)
    {
        $imagenProductor = ImagenProductor::find($ipd_id);
        return $imagenProductor;
    }


}
