<?php

namespace App\View\Components;

use App\Services\CategoriaRubroService;
use App\Services\RubroService;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class HeaderBuscar extends Component
{
    public $categorias;
    protected $rubroService,$categoriaRubroService;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(RubroService $rubroService,CategoriaRubroService $categoriaRubroService)
    {
        $this->categorias = new Collection();
        $this->rubroService = $rubroService;
        $this->categoriaRubroService = $categoriaRubroService;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        //armado de las categorias para mostrar en el nav de buscar
        $rubros = $this->rubroService->getAllByAc();
        foreach ($rubros as $rubro){
            $categoria = array();
            $categoria['rub_id'] = $rubro->rub_id;
            $categoria['nombre'] = $rubro->nombre;
            $categoria['padres'] = array();
            $categoriasThisRubro = $this->categoriaRubroService->getListaCategoriasACByRubro($rubro->rub_id);
            //padres
            $categoriasPadre = $categoriasThisRubro->filter(function ($value,$key){
                return $value->nivel == 1;
            });
            $padresThis = array();
            foreach ($categoriasPadre as $padre) {
                $padreThis = array();
                $padreThis['cat_id'] = $padre->cat_id;
                $padreThis['nombre'] = $padre->nombre;
                $padreThis['descripcion'] = $padre->descripcion;
                $padreThis['hijos'] = array();
                //hijos
                $categoriasHijo = $categoriasThisRubro->filter(function ($value,$key) use ($padre){
                    return ($value->nivel == 2 && $value->padre_id == $padre->cat_id);
                });
                $hijosThis = array();
                foreach ($categoriasHijo as $hijo){
                    $hijoThis = array();
                    $hijoThis['cat_id'] = $hijo->cat_id;
                    $hijoThis['nombre'] = $hijo->nombre;
                    $hijoThis['descripcion'] = $hijo->descripcion;
                    array_push($hijosThis,$hijoThis);
                }
                $padreThis['hijos'] = $hijosThis;
                array_push($padresThis,$padreThis);
            }
            $categoria['padres'] = $padresThis;
            $this->categorias->push($categoria);
        }
        //end armado de las categorias
        return view('components.header-buscar');
    }
}
