<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificadoFeria extends Model
{
    protected $table = 'cef_certificado_feria';
    protected $primaryKey = 'cef_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'ip',
        'usuario',
        'fecha',
        'estado',
        'fondo',
        'fev_id'
    ];

    public function feriaVirtual() {
        return $this->belongsTo(\App\Models\FeriaVirtual::class, 'fev_id', 'fev_id');
    }

}
