<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    protected $table = 'rub_rubro';
    protected $primaryKey = 'rub_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'nombre',
        'descripcion',
        'estado',
        'imagen_banner',
        'imagen_icono'
    ];

    public function categoriaRubros() {
        return $this->hasMany(\App\Models\CategoriaRubro::class, 'rub_id', 'rub_id');
    }

    public function productores(){
        return $this->hasMany(\App\Models\Productor::class, 'rub_id', 'rub_id');
    }

    public function feriasVirtuales() {
        return $this->hasMany(\App\Models\FeriaVirtual::class, 'rub_id', 'rub_id');
    }
}






