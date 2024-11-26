<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'car_carrito';
    protected $primaryKey = 'car_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'cantidad',
        'precio_venta',
        'fecha',
        'precio_base_delivery',
        'estado',
        'prd_id',
        'usr_id'
    ];
    public function producto() {
        return $this->belongsTo(\App\Models\Producto::class, 'prd_id', 'prd_id');
    }

    public function usuario() {
        return $this->belongsTo(\App\User::class, 'usr_id', 'id');
    }


}
