<?php

namespace App\Models\Dto;

use Illuminate\Database\Eloquent\Model;

class ComunDto extends Model
{
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'id'
    ];
}
