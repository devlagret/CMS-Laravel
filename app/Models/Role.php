<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
       'role_id','name'
    ];
}
