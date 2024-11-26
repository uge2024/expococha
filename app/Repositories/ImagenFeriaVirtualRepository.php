<?php
namespace App\Repositories;
use App\Models\ImagenFeria;
use Illuminate\Support\Facades\Log;

class ImagenFeriaVirtualRepository
{
    protected $imagenFeria;
    public function __construct(ImagenFeria $imagenFeria)
    {
        $this->imagenFeria = $imagenFeria;
    }

    public function save($feriaVirtual,$data):?ImagenFeria
    {
        $fev_id =  $feriaVirtual['fev_id'];
        $arreglo = $data['imagen_banner'];
        $cantidadimagenesbannerhay = substr_count($arreglo,',');
        $i = 0;
        for($a=0; $a<=$cantidadimagenesbannerhay;$a++) {
            $iamgenN = explode(',', $arreglo);
            $imagenFeria = new $this->imagenFeria;
            $imagenFeria->imagen = $iamgenN[$a];
            $imagenFeria->alto = $data['alto_banner'];
            $imagenFeria->ancho = $data['ancho_banner'];
            $imagenFeria->tipo = $data['tipo_banner'];
            $imagenFeria->estado = 'AC';
            $imagenFeria->fev_id = $fev_id;
            $imagenFeria->save();
            $imagenFeria->fresh();
            $i++;
        }

        $imagenFeria2 = new $this->imagenFeria;
        $imagenFeria2->imagen = $data['imagen_afiche'];
        $imagenFeria2->alto = $data['alto_afiche'];
        $imagenFeria2->ancho = $data['ancho_afiche'];
        $imagenFeria2->tipo = $data['tipo_afiche'];
        $imagenFeria2->estado = 'AC';
        $imagenFeria2->fev_id = $fev_id;
        $imagenFeria2->save();
        $imagenFeria2->fresh();
        return $imagenFeria2;
    }

    public function getById($ife_id,$tipo):?ImagenFeria
    {
        $imagenFeria = ImagenFeria::where('ife_id','=',$ife_id)->where('tipo','=',$tipo)->first();
        return $imagenFeria;
    }

    public function update($feriaVirtual,$data)
    {
        $fev_id = $feriaVirtual['fev_id'];
        if(isset($data['imagen_banner'])) {
            $arreglo = $data['imagen_banner'];
            $cantidadimagenesbannerhay = substr_count($arreglo, ',');
            $i = 0;
            for ($a = 0; $a <= $cantidadimagenesbannerhay; $a++) {
                $iamgenN = explode(',', $arreglo);
                $imagenFeria = new $this->imagenFeria;
                $imagenFeria->imagen = $iamgenN[$a];
                $imagenFeria->alto = $data['alto_banner'];
                $imagenFeria->ancho = $data['ancho_banner'];
                $imagenFeria->tipo = $data['tipo_banner'];
                $imagenFeria->estado = 'AC';
                $imagenFeria->fev_id = $fev_id;
                $imagenFeria->save();
                $imagenFeria->fresh();
                $i++;
            }
        }
        if(isset($data['imagen_afiche'])) {
            if($data['ife_id_afiche']!= 0 ) {
                $imagenFeria2 = ImagenFeria::find($data['ife_id_afiche']);
                $imagenFeria2->imagen = $data['imagen_afiche'];
                $imagenFeria2->alto = $data['alto_afiche'];
                $imagenFeria2->ancho = $data['ancho_afiche'];
                $imagenFeria2->tipo = $data['tipo_afiche'];
                $imagenFeria2->estado = 'AC';
                $imagenFeria2->fev_id = $fev_id;
                $imagenFeria2->save();
            }else{
                $imagenFeria2 = new $this->imagenFeria;
                $imagenFeria2->imagen = $data['imagen_afiche'];
                $imagenFeria2->alto = $data['alto_afiche'];
                $imagenFeria2->ancho = $data['ancho_afiche'];
                $imagenFeria2->tipo = $data['tipo_afiche'];
                $imagenFeria2->estado = 'AC';
                $imagenFeria2->fev_id = $fev_id;
                $imagenFeria2->save();
                $imagenFeria2->fresh();
            }
        }
        return $data;
    }

    public function getListaImagenFeriaVirtualByFeriaVirtual($fev_id,$tipo)
    {
        $imagenesFeria = ImagenFeria::where([
            ['fev_id','=',$fev_id],
            ['tipo','=',$tipo],
            ['estado','=','AC']
        ])->orderBy('fev_id','asc')->get();
        return $imagenesFeria;
    }
}
