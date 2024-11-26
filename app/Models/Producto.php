<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'prd_producto';
    protected $primaryKey = 'prd_id';
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
        'fecha_inicio_oferta',
        'fecha_fin_oferta'
    ];

    public function imagenesProducto() {
        return $this->hasMany(\App\Models\ImagenProducto::class, 'prd_id', 'prd_id');
    }

    public function productor() {
        return $this->belongsTo(\App\Models\Productor::class, 'pro_id', 'pro_id');
    }

    public function categoria() {
        return $this->belongsTo(\App\Models\CategoriaRubro::class, 'cat_id', 'cat_id');
    }

    public function ventas(){
        return $this->hasMany(\App\Models\Venta::class, 'prd_id', 'prd_id');
    }
    
    public function valoracionesProducto(){
        return $this->hasMany(\App\Models\ValoracionProducto::class, 'prd_id', 'prd_id');
    }

    public function denuncias() {
        return $this->hasMany(\App\Models\Denuncia::class, 'prd_id', 'prd_id');
    }

    public function feriaProductos(){
        return $this->hasMany(\App\Models\FeriaProducto::class, 'prd_id', 'prd_id');
    }
    
}
