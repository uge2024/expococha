<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValoracionProducto extends Model
{
    protected $table = 'vpd_valoracion_producto';
    protected $primaryKey = 'vpd_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'puntuacion',
        'valoracion',
        'fecha',
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
