<?php

namespace App\Models\Dto;

use Illuminate\Database\Eloquent\Model;

class ValoracionProductorDto extends Model
{
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'vprId'
    ];
}
