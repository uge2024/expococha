<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $table = 'bac_backup';
    protected $primaryKey = 'bac_id';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $hidden = [];
    public $fillable = [
        'ip',
        'usuario',
        'fecha',
        'archivo'
    ];
}
