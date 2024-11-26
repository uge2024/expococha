<?php
namespace App\Repositories;

use App\Models\ImagenFeriaProducto;
use Illuminate\Support\Facades\DB;

class ImagenFeriaProductoRepository
{
    protected $imagenFeriaProducto;
    public function __construct(ImagenFeriaProducto $imagenFeriaProducto)
    {
        $this->imagenFeriaProducto = $imagenFeriaProducto;
    }

    public function save($feriaProducto,$data):?ImagenFeriaProducto
    {
        $fpr_id = $feriaProducto['fpr_id'];
        $arreglom = $data['imagen_producto_m'];
        $cantidadimagenesbannerhay = substr_count($arreglom,',');
        $i = 0;
        $dia  = date("d"); $mes  = date("m");
        $time = time();
        $uniq = uniqid();
        for($a=0; $a<=$cantidadimagenesbannerhay;$a++) {
            $iamgenN = explode(',', $arreglom);
            $imagenFeriaProducto = new $this->imagenFeriaProducto;
            $imagenFeriaProducto->imagen = $iamgenN[$a];
            $imagenFeriaProducto->alto = $data['alto_imagen_m'];
            $imagenFeriaProducto->ancho = $data['ancho_imagen_m'];
            $imagenFeriaProducto->tipo = $data['tipo_imagen_m'];
            $numero_imagen = $time.''.$uniq.''.$dia.''.$mes.''.$a;
            $imagenFeriaProducto->numero_imagen= $numero_imagen;
            $imagenFeriaProducto->estado = 'AC';
            $imagenFeriaProducto->fpr_id = $fpr_id;
            $imagenFeriaProducto->save();
            $imagenFeriaProducto->fresh();
            $i++;
        }
        $arreglop = $data['imagen_producto_p'];
        $cantidadimagenesbannerhay = substr_count($arreglop,',');
        $i = 0;
        for($a=0; $a<=$cantidadimagenesbannerhay;$a++) {
            $iamgenN = explode(',', $arreglop);
            $imagenFeriaProducto = new $this->imagenFeriaProducto;
            $imagenFeriaProducto->imagen = $iamgenN[$a];
            $imagenFeriaProducto->alto = $data['alto_imagen_p'];
            $imagenFeriaProducto->ancho = $data['ancho_imagen_p'];
            $imagenFeriaProducto->tipo = $data['tipo_imagen_p'];
            $imagenFeriaProducto->estado = 'AC';
            $numero_imagen = $time.''.$uniq.''.$dia.''.$mes.''.$a;
            $imagenFeriaProducto->numero_imagen= $numero_imagen;
            $imagenFeriaProducto->fpr_id = $fpr_id;
            $imagenFeriaProducto->save();
            $i++;
        }

        return $imagenFeriaProducto->fresh();
    }

    public function getListaImagenProductoByProducto($fpr_id,$tipo)
    {
        $imagenFeriaProducto = ImagenFeriaProducto::where([
            ['fpr_id','=',$fpr_id],
            ['tipo','=',$tipo],
            ['estado','=','AC']
        ])->orderBy('prd_id','asc')->get();

        return $imagenFeriaProducto;
    }

    public function update($feriaProducto,$data)
    {
        $fpr_id = $feriaProducto['fpr_id'];
        $dia  = date("d"); $mes  = date("m");
        $time = time();
        $uniq = uniqid();
        if(isset($data['imagen_producto_m'])) {
            $arreglom = $data['imagen_producto_m'];
            $cantidadimagenesbannerhay = substr_count($arreglom, ',');
            $i = 0;
            for ($a = 0; $a <= $cantidadimagenesbannerhay; $a++) {
                $iamgenN = explode(',', $arreglom);
                $imagenFeriaProducto = new $this->imagenFeriaProducto;
                $imagenFeriaProducto->imagen = $iamgenN[$a];
                $imagenFeriaProducto->alto = $data['alto_imagen_m'];
                $imagenFeriaProducto->ancho = $data['ancho_imagen_m'];
                $imagenFeriaProducto->tipo = $data['tipo_imagen_m'];
                $imagenFeriaProducto->estado = 'AC';
                $numero_imagen = $time.''.$uniq.''.$dia.''.$mes.''.$a;
                $imagenFeriaProducto->numero_imagen= $numero_imagen;
                $imagenFeriaProducto->fpr_id = $fpr_id;
                $imagenFeriaProducto->save();
                $imagenFeriaProducto->fresh();
                $i++;
            }
        }
        if(isset($data['imagen_producto_p'])) {
            $arreglop = $data['imagen_producto_p'];
            $cantidadimagenesbannerhay = substr_count($arreglop, ',');
            $i = 0;
            for ($a = 0; $a <= $cantidadimagenesbannerhay; $a++) {
                $iamgenN = explode(',', $arreglop);
                $imagenFeriaProducto = new $this->imagenFeriaProducto;
                $imagenFeriaProducto->imagen = $iamgenN[$a];
                $imagenFeriaProducto->alto = $data['alto_imagen_p'];
                $imagenFeriaProducto->ancho = $data['ancho_imagen_p'];
                $imagenFeriaProducto->tipo = $data['tipo_imagen_p'];
                $imagenFeriaProducto->estado = 'AC';
                $numero_imagen = $time.''.$uniq.''.$dia.''.$mes.''.$a;
                $imagenFeriaProducto->numero_imagen= $numero_imagen;
                $imagenFeriaProducto->fpr_id = $fpr_id;
                $imagenFeriaProducto->save();
                $i++;
            }
        }
        return $data;
    }

    public function getListaImagenFeriaProductoByProducto($fpr_id,$tipo)
    {
        $imagenFeriaProducto = imagenFeriaProducto::where([
            ['fpr_id','=',$fpr_id],
            ['tipo','=',$tipo],
            ['estado','=','AC']
        ])->orderBy('fpr_id','asc')->get();

        return $imagenFeriaProducto;
    }

    public function getAllImagenesAcMatrizByFeriaProducto($fpr_id)
    {
        $sql = "select
                m1.fpr_id as fpr_id
                ,m1.tipo as tipo1
                ,m1.imagen as imagen1
                ,m2.tipo as tipo2
                ,m2.imagen as imagen2
                from
                (
                    select ipf_id,imagen,tipo,numero_imagen,fpr_id from ipf_imagen_producto_feria
                    where fpr_id = $fpr_id and tipo = 12 and estado = 'AC'
                    order by ipf_id asc
                ) as m1
                left join
                (
                    select ipf_id,imagen,tipo,numero_imagen,fpr_id from ipf_imagen_producto_feria
                    where fpr_id = $fpr_id and tipo = 8 and estado = 'AC'
                ) as m2 on m1.numero_imagen = m2.numero_imagen ";
        return DB::select($sql);
    }

}
