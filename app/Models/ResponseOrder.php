<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponseOrder extends Model
{
    
    protected $table = 'response_orders';
    protected $primaryKey = 'response_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'response_id', 'product_order_id', 'product_order_requests_id', 'warehouse_id','quantity', 'is_received'
    ];
}
