<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    //
    protected $table = 'privileges';
    protected $fillable = [
        'permision_id', 'role_id'
    ];
}
