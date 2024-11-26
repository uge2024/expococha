<?php

namespace App\Models\Dto;

use Illuminate\Database\Eloquent\Model;

class RubroDto extends Model
{
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'rubId',
        'nombre',
        'descripcion',
        'estado',
        'imagenBanner',
        'imagenIcono'
    ];
}
