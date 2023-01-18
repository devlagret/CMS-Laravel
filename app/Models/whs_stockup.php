<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class whs_stockup extends Model
{
    protected $casts = [
        'items' => 'text'
    ];
}
