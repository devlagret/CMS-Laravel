<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    //
    protected $table = 'logs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'datetime', 'activity', 'detail'
    ];
    public $timestamps = false;

}
