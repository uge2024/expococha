<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table = 'ins_institucion';
    protected $primaryKey = 'ins_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'sigla',
        'nombre',
        'descripcion',
        'direccion',
        'imagen_icono',
        'imagen_reporte',
        'imagen_banner',
        'link_facebook',
        'link_twiter',
        'link_instagram',
        'link_youtube',
        'celular',
        'celular_wp',
        'estado'

    ];
}
