<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CategoriaRubro extends Model
{
    protected $table = 'cat_categoria_rubro';
    protected $primaryKey = 'cat_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'rub_id',
        'nombre',
        'descripcion',
        'nivel',
        'padre_id',
        'estado'
    ];

    public function rubros() {
        return $this->belongsTo(\App\Models\Rubro::class, 'rub_id', 'rub_id');
    }
    public function categoriaRubros() {
        return $this->belongsTo(\App\Models\CategoriaRubro::class, 'padre_id' );
    }


}
