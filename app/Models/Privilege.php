<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    //
    public function permissions()
    {
    return $this->belongsTo(Permision::class,'permision_id');
    //return $this->hasOne(Permision::class,'permision_id');
    }
    protected $primaryKey = 'role_id';
    protected $table = 'privileges';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'permision_id', 'role_id'
    ];
}
