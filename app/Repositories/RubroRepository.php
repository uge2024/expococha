<?php
namespace App\Repositories;
use App\Models\Rubro;
use Illuminate\Support\Collection;

class RubroRepository
{
    protected $rubro;
    public function __construct(Rubro $rubro)
    {
        $this->rubro = $rubro;
    }

    public function getAll(): Collection
    {
        return $this->rubro->all();
    }

    public function getAllByAc(): Collection
    {
        return $this->rubro->where([
            ['estado','=','AC']
        ])->orderBy('nombre','asc')->get();
    }

    public function getRubros(): Collection
    {
        return $this->rubro->all();
    }

    public function save($data):?Rubro
    {
        $rubro = new $this->rubro;
        $rubro->nombre = $data['nombre'];
        $rubro->descripcion = $data['descripcion'];
        $rubro->estado = $data['estado'];
        if(isset($data['imagen_banner'])){
            $rubro->imagen_banner = $data['imagen_banner'];
        }
        if(isset($data['imagen_icono'])){
            $rubro->imagen_icono = $data['imagen_icono'];
        }
        $rubro->save();
        return $rubro->fresh();
    }

    public function getById($rub_id):?Rubro
    {
        $rubro = Rubro::find($rub_id);
        return $rubro;
    }

    public function update($data):?Rubro
    {
        $rubro = Rubro::find($data['rub_id']);
        $rubro->nombre = $data['nombre'];
        $rubro->descripcion = $data['descripcion'];
        $rubro->estado = $data['estado'];
        if(isset($data['imagen_banner'])){
            $rubro->imagen_banner = $data['imagen_banner'];
        }
        if(isset($data['imagen_icono'])){
            $rubro->imagen_icono = $data['imagen_icono'];
        }
        $rubro->save();
        return $rubro->fresh();
    }

    public function delete($data,$texto):?Rubro
    {
        $rubro = Rubro::find($data['rub_id']);
        if($texto == 'inhabilitar') {
            $rubro->estado = 'EL';
            $rubro->save();
            return $rubro->fresh();
        }
        if($texto == 'habilitar'){
            $rubro->estado = 'AC';
            $rubro->save();
            return $rubro->fresh();
        }
    }

    public function getComboRubros():Collection
    {
        $listarubro = Rubro::where([
            ['estado','=','AC'],
        ])->orderBy('nombre','asc')->pluck("nombre",'rub_id','listarubro')->prepend('Seleccione un rubro','0');
        return $listarubro;
    }

    public function getAllPaginate($limit)
    {
        return $this->rubro->where([
        ])->orderBy('nombre','asc')->paginate($limit);
    }


}



