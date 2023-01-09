<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    protected $fillable = [
        'branch_name',
        'leader_name',
        'contact',
        'address',
    ];
}
