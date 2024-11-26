<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TipoPublicidad extends Model
{
    protected $table = 'tpu_tipo_publicidad';
    protected $primaryKey = 'tpu_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'tipo',
        'nombre',
        'alto',
        'ancho',
        'costo_pedido',
        'disponible',
        'estado'
    ];

    public function publicidades() {
        return $this->hasMany(\App\Models\Publicidad::class, 'tpu_id', 'tpu_id');
    }
}
