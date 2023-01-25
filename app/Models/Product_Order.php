<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Order extends Model
{
    protected $casts = [
        'items' => 'text'
    ];
}
