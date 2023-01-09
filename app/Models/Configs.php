<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configs extends Model
{
    //
    protected $table = 'configs';
    protected $primaryKey = 'key';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'key', 'value','type'
    ];
}
