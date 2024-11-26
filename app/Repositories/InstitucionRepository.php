<?php


namespace App\Repositories;


use App\Models\Institucion;
use Illuminate\Support\Collection;

class InstitucionRepository
{

    protected $institucion;
    public function __construct(Institucion $institucion)
    {
        $this->institucion = $institucion;
    }

    public function getAll(): Collection
    {
        return $this->institucion->all();
    }

    public function getById($ins_id):?Institucion
    {
        $institucion = Institucion::find($ins_id);
        return $institucion;
    }

    public function save($data):?Institucion
    {
        $institucion = new $this->institucion;
        $institucion->ins_id = $data['ins_id'];
        $institucion->nombre = $data['nombre'];
        $institucion->sigla = $data['sigla'];
        $institucion->descripcion = $data['descripcion'];
        $institucion->direccion = $data['direccion'];
        $institucion->imagen_icono = $data['imagen_icono_imagen'];
        if(isset($data['imagen_reporte_imagen'])){
            $institucion->imagen_reporte = $data['imagen_reporte_imagen'];
        }else{
            $institucion->imagen_reporte = null;
        }
        if(isset($data['imagen_banner_imagen'])){
            $institucion->imagen_banner = $data['imagen_banner_imagen'];
        }else{
            $institucion->imagen_banner = null;
        }
        if(isset($data['link_facebook'])){
            $institucion->link_facebook = $data['link_facebook'];
        }else{
            $institucion->link_facebook = null;
        }
        if(isset($data['link_twiter'])){
            $institucion->link_twiter = $data['link_twiter'];
        }else{
            $institucion->link_twiter = null;
        }
        if(isset($data['link_instagram'])){
            $institucion->link_instagram = $data['link_instagram'];
        }else{
            $institucion->link_instagram = null;
        }
        if(isset($data['link_youtube'])){
            $institucion->link_youtube = $data['link_youtube'];
        }else{
            $institucion->link_youtube = null;
        }
        $institucion->celular = $data['celular'];
        $institucion->celular_wp = $data['celular_wp'];
        $institucion->estado = $data['estado'];
        $institucion->save();
        return $institucion->fresh();
    }

    public function update($data):?Institucion
    {
        $institucion = Institucion::find($data['ins_id']);
        $institucion->ins_id = $data['ins_id'];
        $institucion->nombre = $data['nombre'];
        $institucion->sigla = $data['sigla'];
        $institucion->descripcion = $data['descripcion'];
        $institucion->direccion = $data['direccion'];
        if(isset($data['imagen_icono_imagen'])){
            $institucion->imagen_icono = $data['imagen_icono_imagen'];
        }
        if(isset($data['imagen_reporte_imagen'])){
            $institucion->imagen_reporte = $data['imagen_reporte_imagen'];
        }
        if(isset($data['imagen_banner_imagen'])){
            $institucion->imagen_banner = $data['imagen_banner_imagen'];
        }


        if(isset($data['link_facebook'])){
            $institucion->link_facebook = $data['link_facebook'];
        }else{
            $institucion->link_facebook = null;
        }
        if(isset($data['link_twiter'])){
            $institucion->link_twiter = $data['link_twiter'];
        }else{
            $institucion->link_twiter = null;
        }
        if(isset($data['link_instagram'])){
            $institucion->link_instagram = $data['link_instagram'];
        }else{
            $institucion->link_instagram = null;
        }
        if(isset($data['link_youtube'])){
            $institucion->link_youtube = $data['link_youtube'];
        }else{
            $institucion->link_youtube = null;
        }
        $institucion->celular = $data['celular'];
        $institucion->celular_wp = $data['celular_wp'];
        $institucion->estado = $data['estado'];
        $institucion->save();
        return $institucion->fresh();
    }
}
