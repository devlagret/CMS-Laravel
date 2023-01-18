<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    //
    protected $table = 'tokens';
    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'uid','token'
    ];


}
