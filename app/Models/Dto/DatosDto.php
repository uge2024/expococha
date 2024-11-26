<?php

namespace App\Models\Dto;

use Illuminate\Database\Eloquent\Model;

class DatosDto extends Model
{
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'sigla',
        'nombre',
        'descripcion',
        'direccion',
        'imagenIcono',
        'imagenBanner',
        'linkFacebook',
        'linkTwitter',
        'linkInstagram',
        'linkYoutube',
        'celular',
        'celularWhatsapp'
    ];
}
