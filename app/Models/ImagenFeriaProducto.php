<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ImagenFeriaProducto extends Model
{
    protected $table = 'ipf_imagen_producto_feria';
    protected $primaryKey = 'ipf_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'imagen',
        'alto',
        'ancho',
        'tipo',
        'fpr_id',
        'estado',
        'numero_imagen'
    ];

    public function feriaproducto() {
        return $this->belongsTo(\App\Models\FeriaProducto::class, 'fpr_id', 'fpr_id');
    }

}