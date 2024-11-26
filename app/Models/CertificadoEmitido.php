<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CertificadoEmitido extends Model
{
    protected $table = 'cee_certificado_emitido';
    protected $primaryKey = 'cee_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'fecha_emitido',
        'fecha_reimpresion',
        'codigo_qr',
        'estado',
        'fec_id',
        'usr_id'
    ];

    public function feriaCertificado() {
        return $this->belongsTo(\App\Models\FeriaCertificado::class, 'fec_id', 'fec_id');
    }

    public function usuario() {
        return $this->belongsTo(\App\User::class, 'usr_id', 'id');
    }

}







