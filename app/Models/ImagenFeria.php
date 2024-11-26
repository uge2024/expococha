<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ImagenFeria extends Model
{
    protected $table = 'ife_imagen_feria';
    protected $primaryKey = 'ife_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'imagen',
        'alto',
        'ancho',
        'tipo',
        'fev_id',
        'estado'
    ];

    public function feriaVirtual() {
        return $this->belongsTo(\App\Models\FeriaVirtual::class, 'fev_id', 'fev_id');
    }

}
