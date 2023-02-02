<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestOrder extends Model
{
    
    protected $table = 'requestorders';

    protected $keyType = 'string';
    protected $fillable = [
        'product_order_requests_id', 'product_order_id','warehouse_id','quantity'
    ];
}
