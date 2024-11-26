<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Productor extends Model
{
    protected $table = 'pro_productor';
    protected $primaryKey = 'pro_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'nombre_propietario',
        'fecha_registro',
        'direccion',
        'telefono_1',
        'telefono_2',
        'celular',
        'celular_wp',
        'nombre_tienda',
        'actividad',
        'email',
        'longitud',
        'latitud',
        'link_facebook',
        'link_twiter',
        'link_instagram',
        'link_youtube',
        'estado',
        'estado_tienda',
        'puntuacion',
        'entidad_financiera',
        'cuenta',
        'titular_cuenta',
        'rub_id',
        'usr_id',
        'aso_id'
    ];

    public function imagenProductores() {
        return $this->hasMany(\App\Models\ImagenProductor::class, 'pro_id', 'pro_id');
    }

    public function deliverys() {
        return $this->hasMany(\App\Models\Delivery::class, 'pro_id', 'pro_id');
    }

    public function usuario() {
        return $this->belongsTo(\App\User::class, 'usr_id', 'id');
    }

    public function rubro() {
        return $this->belongsTo(\App\Models\Rubro::class, 'rub_id', 'rub_id');
    }

    public function valoracionesProductor(){
        return $this->hasMany(\App\Models\ValoracionProductor::class, 'pro_id', 'pro_id');
    }

    public function productos(){
        return $this->hasMany(\App\Models\Producto::class, 'pro_id', 'pro_id');
    }

    public function correosEnviados(){
        return $this->hasMany(\App\Models\CorreoEnviado::class, 'pro_id', 'pro_id');
    }

    public function feriaProductores(){
        return $this->hasMany(\App\Models\FeriaProductor::class, 'pro_id', 'pro_id');
    }

    public function feriaProductos(){
        return $this->hasMany(\App\Models\FeriaProducto::class, 'pro_id', 'pro_id');
    }

    public function asociacion() {
        return $this->belongsTo(\App\Models\Asociacion::class, 'aso_id', 'aso_id');
    }

}






