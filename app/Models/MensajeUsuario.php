<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajeUsuario extends Model
{
    protected $table = 'meu_mensaje_usuario';
    protected $primaryKey = 'meu_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'mensaje','fecha','estado','visto','usr_id_r','usr_id_e'
    ];

    public function usuarioRecive() {
        return $this->belongsTo(\App\User::class, 'usr_id_r', 'id');
    }

    public function usuarioEnvia() {
        return $this->belongsTo(\App\User::class, 'usr_id_e', 'id');
    }

}
