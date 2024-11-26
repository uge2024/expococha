<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CorreoEnviado extends Model
{
    protected $table = 'cen_correo_enviado';
    protected $primaryKey = 'cen_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'enviado_por',
        'enviado_a',
        'asunto',
        'descripcion',
        'estado',
        'pro_id'

    ];

    public function productor() {
        return $this->belongsTo(\App\Models\Productor::class, 'pro_id', 'pro_id');
    }


}
