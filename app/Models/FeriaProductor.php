<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FeriaProductor extends Model
{
    protected $table = 'fpd_feria_productor';
    protected $primaryKey = 'fpd_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
    	'fecha_inscripcion',
        'comprobante',
        'monto',
        'fecha_pago',
        'estado',
        'pro_id',
        'fev_id',
        'usr_id'
    ];

    public function productor() {
        return $this->belongsTo(\App\Models\Productor::class, 'pro_id', 'pro_id');
    }

    public function feriaVirtual() {
        return $this->belongsTo(\App\Models\FeriaVirtual::class, 'fev_id', 'fev_id');
    }

    public function usuario() {
        return $this->belongsTo(\App\User::class, 'usr_id', 'id');
    }

    public function feriaProductos(){
        return $this->hasMany(\App\Models\FeriaProducto::class, 'fpd_id', 'fpd_id');
    }
}
