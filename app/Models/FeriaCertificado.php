<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FeriaCertificado extends Model
{
    protected $table = 'fec_feria_certificado';
    protected $primaryKey = 'fec_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'fecha',
        'firma1',
        'firma2',
        'estado',
        'fev_id',
        'usr_id'
    ];

    public function CertificadosEmitidos() {
        return $this->hasMany(\App\Models\CertificadoEmitido::class, 'fec_id', 'fec_id');
    }

    public function usuario() {
        return $this->belongsTo(\App\User::class, 'usr_id', 'id');
    }
}