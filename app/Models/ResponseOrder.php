<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponseOrder extends Model
{
    
    protected $table = 'response_orders';

    protected $keyType = 'string';
    protected $fillable = [
        'response_id', 'product_order_id', 'product_order_requests_id', 'warehouse_id','quantity'
    ];
}
