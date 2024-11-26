<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ImagenProductor extends Model
{
    protected $table = 'ipr_imagen_productor';
    protected $primaryKey = 'ipd_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'imagen',
        'alto',
        'ancho',
        'tipo',
        'pro_id',
        'estado'
    ];
//antes public function productores() {
    public function productor() {
        return $this->belongsTo(\App\Models\Productor::class, 'pro_id', 'pro_id');
    }

}
