<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $table = 'cer_certificado';
    protected $primaryKey = 'cer_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'ip',
        'usuario',
        'fecha',
        'codigo',
        'nombre',
        'feria',
        'version',
        'fecha_inicio',
        'fecha_final',
        'estado',
        'pro_id',
        'fev_id'
    ];

}
