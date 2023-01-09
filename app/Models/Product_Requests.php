<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Requests extends Model
{
    protected $fillable = [
        'branch_id',
        'product_code',
        'amount',
        'order_date',
        'out_date',
        'status',
    ];
}
