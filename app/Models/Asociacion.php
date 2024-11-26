<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Asociacion extends  Model
{
    protected $table = 'aso_asociacion';
    protected $primaryKey = 'aso_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'sigla',
        'nombre',
        'actividad',
        'direccion',
        'telefono',
        'celular',
        'estado'
    ];
}

