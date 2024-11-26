<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
    protected $table = 'ipd_imagen_producto';
    protected $primaryKey = 'ipd_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'imagen',
        'alto',
        'ancho',
        'tipo',
        'prd_id',
        'estado',
        'numero_imagen'
    ];

    public function producto() {
        return $this->belongsTo(\App\Models\Producto::class, 'prd_id', 'prd_id');
    }

}
