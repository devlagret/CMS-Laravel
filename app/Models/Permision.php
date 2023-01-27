<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permision extends Model
{
    //
    protected $table = 'permisions';
    protected $primaryKey = 'permision_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'permision_id','name','label','group'
    ];
}
