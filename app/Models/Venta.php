<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ven_venta';
    protected $primaryKey = 'ven_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'tipo_pago',
        'estado_venta',
        'estado_delivery',
        'estado',
        'cantidad',
        'precio_venta',
        'subtotal',
        'precio_base_delivery',
        'fecha',
        'comprobante',
        'prd_id',
        'usr_id',
        'del_id',
        'fpr_id'
    ];

    public function producto() {
        return $this->belongsTo(\App\Models\Producto::class, 'prd_id', 'prd_id');
    }

    public function usuario() {
        return $this->belongsTo(\App\User::class, 'usr_id', 'id');
    }

    public function delivery() {
        return $this->belongsTo(\App\Models\Delivery::class, 'del_id', 'del_id');
    }

    public function feriaProducto() {
        return $this->belongsTo(\App\Models\FeriaProducto::class, 'fpr_id', 'fpr_id');
    }
                

}

