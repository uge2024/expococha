<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FeriaProducto extends Model
{
    protected $table = 'fpr_feria_producto';
    protected $primaryKey = 'fpr_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'nombre_producto',
        'existencia',
        'puntuacion',
        'descripcion1',
        'descripcion2',
        'precio',
        'precio_oferta',
        'descuento',
        'existencia_minima',
        'fecha_registro',
        'fecha_modificacion',
        'codigo_qr_venta',
        'estado',
        'cat_id',
        'pro_id',
        'prd_id',
        'fpd_id',
        'fecha_inicio_oferta',
        'fecha_fin_oferta'
    ];

    public function categoria() {
        return $this->belongsTo(\App\Models\CategoriaRubro::class, 'cat_id', 'cat_id');
    }

    public function producto() {
        return $this->belongsTo(\App\Models\Producto::class, 'prd_id', 'prd_id');
    }

    public function productor() {
        return $this->belongsTo(\App\Models\Productor::class, 'pro_id', 'pro_id');
    }

    public function feriaProductor() {
        return $this->belongsTo(\App\Models\FeriaProductor::class, 'fpd_id', 'fpd_id');
    }

    public function imagenesFeriaProductos() {
        return $this->hasMany(\App\Models\ImagenFeriaProducto::class, 'fpr_id', 'fpr_id');
    }

    public function ventas(){
        return $this->hasMany(\App\Models\Venta::class, 'fpr_id', 'fpr_id');
    }

}
