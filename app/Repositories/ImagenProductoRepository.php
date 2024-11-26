<?php


namespace App\Repositories;
use App\Models\ImagenProducto;
use Illuminate\Support\Facades\DB;

class ImagenProductoRepository
{
    protected $imagenProducto;
    public function __construct(ImagenProducto $imagenProducto)
    {
        $this->imagenProducto = $imagenProducto;
    }

    public function save($producto,$data):?ImagenProducto
    {
        $prd_id = $producto['prd_id'];
        $arreglom = $data['imagen_producto_m'];
        $cantidadimagenesbannerhay = substr_count($arreglom,',');
        $i = 0;
        $dia  = date("d"); $mes  = date("m");
        $time = time();
        $uniq = uniqid();
        for($a=0; $a<=$cantidadimagenesbannerhay;$a++) {
            $iamgenN = explode(',', $arreglom);
            $imagenProducto = new $this->imagenProducto;
            $imagenProducto->imagen = $iamgenN[$a];
            $imagenProducto->alto = $data['alto_imagen_m'];
            $imagenProducto->ancho = $data['ancho_imagen_m'];
            $imagenProducto->tipo = $data['tipo_imagen_m'];
            $numero_imagen = $time.''.$uniq.''.$dia.''.$mes.''.$a;
            $imagenProducto->numero_imagen= $numero_imagen;
            $imagenProducto->estado = 'AC';
            $imagenProducto->prd_id = $prd_id;
            $imagenProducto->save();
            $imagenProducto->fresh();
            $i++;
        }
        $arreglop = $data['imagen_producto_p'];
        $cantidadimagenesbannerhay = substr_count($arreglop,',');
        $i = 0;
        for($a=0; $a<=$cantidadimagenesbannerhay;$a++) {
            $iamgenN = explode(',', $arreglop);
            $imagenProducto = new $this->imagenProducto;
            $imagenProducto->imagen = $iamgenN[$a];
            $imagenProducto->alto = $data['alto_imagen_p'];
            $imagenProducto->ancho = $data['ancho_imagen_p'];
            $imagenProducto->tipo = $data['tipo_imagen_p'];
            $imagenProducto->estado = 'AC';
            $numero_imagen = $time.''.$uniq.''.$dia.''.$mes.''.$a;
            $imagenProducto->numero_imagen= $numero_imagen;
            $imagenProducto->prd_id = $prd_id;
            $imagenProducto->save();
            $i++;
        }

        return $imagenProducto->fresh();
    }

    public function getListaImagenProductoByProducto($prd_id,$tipo)
    {
        $imagenesProducto = ImagenProducto::where([
            ['prd_id','=',$prd_id],
            ['tipo','=',$tipo],
            ['estado','=','AC']
        ])->orderBy('prd_id','asc')->get();

        return $imagenesProducto;
    }

    public function update($producto,$data)
    {
        $prd_id = $producto['prd_id'];
        $dia  = date("d"); $mes  = date("m");
        $time = time();
        $uniq = uniqid();
        if(isset($data['imagen_producto_m'])) {
            $arreglom = $data['imagen_producto_m'];
            $cantidadimagenesbannerhay = substr_count($arreglom, ',');
            $i = 0;
            for ($a = 0; $a <= $cantidadimagenesbannerhay; $a++) {
                $iamgenN = explode(',', $arreglom);
                $imagenProducto = new $this->imagenProducto;
                $imagenProducto->imagen = $iamgenN[$a];
                $imagenProducto->alto = $data['alto_imagen_m'];
                $imagenProducto->ancho = $data['ancho_imagen_m'];
                $imagenProducto->tipo = $data['tipo_imagen_m'];
                $imagenProducto->estado = 'AC';
                $numero_imagen = $time.''.$uniq.''.$dia.''.$mes.''.$a;
                $imagenProducto->numero_imagen= $numero_imagen;
                $imagenProducto->prd_id = $prd_id;
                $imagenProducto->save();
                $imagenProducto->fresh();
                $i++;
            }
        }
        if(isset($data['imagen_producto_p'])) {
            $arreglop = $data['imagen_producto_p'];
            $cantidadimagenesbannerhay = substr_count($arreglop, ',');
            $i = 0;
            for ($a = 0; $a <= $cantidadimagenesbannerhay; $a++) {
                $iamgenN = explode(',', $arreglop);
                $imagenProducto = new $this->imagenProducto;
                $imagenProducto->imagen = $iamgenN[$a];
                $imagenProducto->alto = $data['alto_imagen_p'];
                $imagenProducto->ancho = $data['ancho_imagen_p'];
                $imagenProducto->tipo = $data['tipo_imagen_p'];
                $imagenProducto->estado = 'AC';
                $numero_imagen = $time.''.$uniq.''.$dia.''.$mes.''.$a;
                $imagenProducto->numero_imagen= $numero_imagen;
                $imagenProducto->prd_id = $prd_id;
                $imagenProducto->save();
                $i++;
            }
        }
        return $data;
    }


    public function getAllImagenesAcMatrizByProducto($prd_id)
    {
        $sql = "select
                m1.prd_id as prd_id
                ,m1.tipo as tipo1
                ,m1.imagen as imagen1
                ,m2.tipo as tipo2
                ,m2.imagen as imagen2
                from
                (
                    select ipd_id,imagen,tipo,numero_imagen,prd_id from ipd_imagen_producto
                    where prd_id = $prd_id and tipo = 12 and estado = 'AC'
                    order by ipd_id asc
                ) as m1
                left join
                (
                    select ipd_id,imagen,tipo,numero_imagen,prd_id from ipd_imagen_producto
                    where prd_id = $prd_id and tipo = 8 and estado = 'AC'
                ) as m2 on m1.numero_imagen = m2.numero_imagen ";
        return DB::select($sql);
    }

}
