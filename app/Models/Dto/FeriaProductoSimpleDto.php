<?php

namespace App\Models\Dto;

use Illuminate\Database\Eloquent\Model;

class FeriaProductoSimpleDto extends Model
{
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'fprId',
        'nombreProducto',
        'imagen',
        'existencia',
        'puntuacion',
        'descripcionCorta',
        'precio',
        'precioOferta',
        'descuento',
        'existenciaMinima',
        'estado',
        'catId',
        'proId',
        'fechaInicioOferta',
        'fechaFinOferta',
        'esOferta',
        'esNuevo',
        'nombreTienda'
    ];
}
