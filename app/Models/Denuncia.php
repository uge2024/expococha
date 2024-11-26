<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    protected $table = 'den_denuncia';
    protected $primaryKey = 'den_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'denuncia',
        'fecha',
        'estado_visto',
        'estado',
        'pro_id',
        'prd_id',
        'usr_id'
        //,'fpr_id'
    ];

    public function productor() {
        return $this->belongsTo(\App\Models\Productor::class, 'pro_id', 'pro_id');
    }

    public function usuario() {
        return $this->belongsTo(\App\User::class, 'usr_id', 'id');
    }

    public function producto() {
        return $this->belongsTo(\App\Models\Producto::class, 'prd_id', 'prd_id');
    }




}
