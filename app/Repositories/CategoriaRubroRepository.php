<?php

namespace App\Repositories;
use Illuminate\Support\Collection;
use App\Models\CategoriaRubro;
use Illuminate\Support\Facades\Log;

class CategoriaRubroRepository
{
    protected $categoriaRubro;
    public function __construct(CategoriaRubro $categoriaRubro)
    {
        $this->categoriaRubro = $categoriaRubro;
    }
    public function getAll(): Collection
    {
        return CategoriaRubro::where([

        ])->orderBy('nivel','asc')->orderBy('nombre','asc')->get();

    }

    public function getAllPaginateCategoriasByRubro($limit,$rub_id)
    {
        return $this->categoriaRubro->where([
            ['rub_id','=',$rub_id]
        ])->orderBy('nivel','asc')->orderBy('nombre','asc')->paginate($limit);
    }


    public function save($data):?CategoriaRubro
    {
        $categoriaRubro = new $this->categoriaRubro;
        $categoriaRubro->nombre = $data['nombre'];
        $categoriaRubro->rub_id = $data['rub_id'];
        $categoriaRubro->descripcion = $data['descripcion'];
        $categoriaRubro->nivel = $data['nivel'];
        if($data['padre_id'] == '0'){
            $categoriaRubro->padre_id = null;
        }else{
            $categoriaRubro->padre_id = $data['padre_id'];
        }
        $categoriaRubro->estado = $data['estado'];
        $categoriaRubro->save();
        return $categoriaRubro->fresh();
    }

    public function getById($cat_id):?CategoriaRubro
    {
        return CategoriaRubro::find($cat_id);
    }

    public function update($data):?CategoriaRubro
    {
        $categoriaRubro = CategoriaRubro::find($data['cat_id']);
        $categoriaRubro->nombre = $data['nombre'];
        $categoriaRubro->rub_id = $data['rub_id'];
        $categoriaRubro->descripcion = $data['descripcion'];
        $categoriaRubro->nivel = $data['nivel'];
        if($data['padre_id'] == '0'){
            $categoriaRubro->padre_id = null;
        }else{
            $categoriaRubro->padre_id = $data['padre_id'];
        }
        $categoriaRubro->estado = $data['estado'];
        $categoriaRubro->save();
        return $categoriaRubro->fresh();
    }

    public function delete($data,$texto):?CategoriaRubro
    {
        $categoriaRubro = CategoriaRubro::find($data['cat_id']);
        if($texto == 'inhabilitar') {
            $categoriaRubro->estado = 'EL';
            $categoriaRubro->save();
            return $rubro->fresh();
        }
        if($texto == 'habilitar'){
            $categoriaRubro->estado = 'AC';
            $categoriaRubro->save();
            return $rubro->fresh();
        }
    }

    public function getComboPadresCategoriaRubro():Collection
    {
        $listaCategoriaRubrosPadre = CategoriaRubro::where([
            ['estado','not like','EL'],
            ['nivel','=',1]
        ])->orderBy('nivel','asc')->orderBy('nombre','asc')->pluck("nombre",'cat_id','listaCategoriaRubrosPadre')->prepend('Pabre','0');

        return $listaCategoriaRubrosPadre;
    }

    public function cargarComboCategoriasByRubro($rub_id)
    {
        $listaCategoriaRubrosPadre = CategoriaRubro::where([
            ['estado','not like','EL'],
            ['nivel','=',1],
            ['rub_id','=',$rub_id]
        ])->orderBy('nivel','asc')->orderBy('nombre','asc')->pluck("nombre",'cat_id','listaCategoriaRubrosPadre')->prepend('Pabre','0');

        return $listaCategoriaRubrosPadre;
    }

    public function getListaCategoriasByRubro($rub_id)
    {
        $listaCategoriaRubrosPadre = CategoriaRubro::where([
            ['estado','not like','EL'],
            ['rub_id','=',$rub_id]
        ])->orderBy('nivel','asc')->orderBy('nombre','asc')->get();

        return $listaCategoriaRubrosPadre;
    }
    public function cargarComboCategoriasByRubroHijos($rub_id)
    {
        $listaCategoriaRubrosPadre = CategoriaRubro::where([
            ['estado','not like','EL'],
            ['nivel','=',2],
            ['rub_id','=',$rub_id]
        ])->orderBy('nombre','asc')->pluck("nombre",'cat_id','listaCategoriaRubrosPadre');

        return $listaCategoriaRubrosPadre;
    }

    public function getListaCategoriasACByRubro($rub_id)
    {
        $listaCategoriaRubrosPadre = CategoriaRubro::where([
            ['estado','not like','EL'],
            ['rub_id','=',$rub_id]
        ])->orderBy('nivel','asc')->orderBy('nombre','asc')->get();

        return $listaCategoriaRubrosPadre;
    }

}
