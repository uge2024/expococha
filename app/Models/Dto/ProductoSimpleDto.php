<?php

namespace App\Models\Dto;

use Illuminate\Database\Eloquent\Model;

class ProductoSimpleDto extends Model
{
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'prdId',
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
