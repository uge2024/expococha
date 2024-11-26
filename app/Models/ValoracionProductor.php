<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ValoracionProductor extends Model
{
    protected $table = 'vpr_valoracion_productor';
    protected $primaryKey = 'vpr_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'puntuacion',
        'valoracion',
        'fecha',
        'estado',
        'pro_id',
        'usr_id'
    ];

    public function productor() {
        return $this->belongsTo(\App\Models\Productor::class, 'pro_id', 'pro_id');
    }

    public function usuario() {
        return $this->belongsTo(\App\User::class, 'usr_id', 'id');
    }
}
