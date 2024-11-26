<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'aud_auditoria';
    protected $primaryKey = 'aud_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'ip',
        'tabla',
        'usuario',
        'fecha',
        'accion',
        'dato_original',
        'dato_nuevo'
    ];
}
