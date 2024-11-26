<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Delivery  extends Model
{
    protected $table = 'del_delivery';
    protected $primaryKey = 'del_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'razon_social',
        'propietario',
        'tipo_transporte',
        'disponible',
        'estado',
        'costo_minimo',
        'costo_maximo',
        'pro_id'
    ];
    public function productores() {
        return $this->belongsTo(\App\Models\Productor::class, 'pro_id', 'pro_id');
    }

    public function ventas() {
        return $this->hasMany(\App\Models\Venta::class, 'del_id', 'del_id');
    }

}
