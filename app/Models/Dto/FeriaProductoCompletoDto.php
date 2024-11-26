<?php

namespace App\Models\Dto;

use Illuminate\Database\Eloquent\Model;

class FeriaProductoCompletoDto extends Model
{
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'fprId',
        'nombreProducto',
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
        'imagenes',
        'detalleProducto',
        'nombreTienda',
        'propietario',
        'comprarCelularWhatsapp',
        'comprarLinkFacebook',
        'comprarImagenQr',
        'comprarEntidadFinanciera',
        'comprarCuenta',
        'compartirLinkProducto'
        //'imagen'
    ];
}
