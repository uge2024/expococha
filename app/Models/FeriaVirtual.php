<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FeriaVirtual extends Model
{
    protected $table = 'fev_feria_virtual';
    protected $primaryKey = 'fev_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
    	'version',
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_final',
        'lugar',
        'direccion',
        'estado',
        'rub_id',
        'longitud',
        'latitud'
    ];

    public function imagenFerias() {
        return $this->hasMany(\App\Models\ImagenFeria::class, 'fev_id', 'fev_id');
    }

    public function rubro() {
        return $this->belongsTo(\App\Models\Rubro::class, 'rub_id', 'rub_id');
    }
}
