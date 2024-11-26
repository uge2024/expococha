<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Publicidad extends Model
{
    protected $table = 'pub_publicidad';
    protected $primaryKey = 'pub_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'fecha_desde',
        'fecha_hasta',
        'solicitante',
        'documento',
        'doc_pago',
        'fecha_pago',
        'monto',
        'link_destino',
        'imagen',
        'tpu_id',
        'estado'
    ];

    public function tipoPublicidad() {
        return $this->belongsTo(\App\Models\TipoPublicidad::class, 'tpu_id', 'tpu_id');
    }

}
