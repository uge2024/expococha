<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'pos_post';
    protected $primaryKey = 'pos_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $attributes =[
        'titulo' => 'Sin titulo'
    ];
    protected $hidden = [];
    public $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'bandera',
        'valor_a',
        'valor_b',
        'valor_c',
        'valor_d',
        'fecha_hora'
    ];
}
